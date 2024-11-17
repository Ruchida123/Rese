<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Str;
use App\Models\Region;
use App\Models\Genre;
use SplFileObject;

class RepresentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $regions = Region::all();
        $region_names = $regions->pluck('name')->toArray();

        $genres = Genre::all();
        $genre_names = $genres->pluck('name')->toArray();

        if (request()->method == Request::METHOD_GET) {
            return [
                'id' => ['sometimes', 'required'],
            ];
        } else {
            return [
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'csvFile' => ['sometimes', 'required', 'mimes:csv,txt'],
                'csv_array' => ['sometimes', 'required', 'array'],
                'csv_array.*.name' => ['required', 'max:50'],
                'csv_array.*.region' => ['required', Rule::in($region_names)],
                'csv_array.*.genre' => ['required', Rule::in($genre_names)],
                'csv_array.*.summary' => ['required', 'max:400'],
                'csv_array.*.image_url' => ['required'],
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => '店舗名を入力してください。',
            'name.string' => '店舗名には、文字を指定してください。',
            'name.max' => '店舗名は、255文字以下にしてください。',
            'id.required' => '店舗情報が存在しません。',
            'csvFile.required' => 'ファイルを選択してください。',
            'csvFile.mimes' => '拡張子が「.csv」のファイルを選択してください。',
        ];
    }

    protected function prepareForValidation()
    {
        $req_file = $this->file('csvFile');
        if (isset($req_file) && strcmp($req_file->getClientMimeType(), 'text/csv') == 0) {
            $file_path = $this->file('csvFile')->path();
            // CSV取得
            $file = new SplFileObject($file_path);
            $file->setFlags(
                SplFileObject::READ_CSV |         // CSVとして行を読み込み
                SplFileObject::READ_AHEAD |       // 先読み／巻き戻しで読み込み
                SplFileObject::SKIP_EMPTY |       // 空行を読み飛ばす
                SplFileObject::DROP_NEW_LINE      // 行末の改行を読み飛ばす
            );
            foreach ($file as $index => $line) {
                // ヘッダーを取得
                if (empty($header)) {
                    $header = $line;
                    continue;
                }
                $csv_array[$index]['name'] = $line[0] == "" ? null : $line[0];
                $csv_array[$index]['region'] = $line[1] == "" ? null : $line[1];
                $csv_array[$index]['genre'] = $line[2] == "" ? null : $line[2];
                $csv_array[$index]['summary'] = $line[3] == "" ? null : $line[3];
                $csv_array[$index]['image_url'] = $line[4] == "" ? null : $line[4];
            }
            $this->merge([
                'csv_array' => $csv_array,     //requestに項目追加
            ]);
        } else {
            $this->merge([
                'csvFile' => $req_file,     //requestに項目追加
            ]);
        }
    }

    public function attributes()
    {
        return [
            'csv_array' => 'CSV',
            'csv_array.*.name' => '店舗名',
            'csv_array.*.region' => '地域',
            'csv_array.*.genre' => 'ジャンル',
            'csv_array.*.summary' => '店舗概要',
            'csv_array.*.image_url' => '画像URL',
        ];
    }

    public function withValidator(Validator $validator) {
        $validator->after(function ($validator) {
            $data = $validator->getData();
            $csv_array = $data['csv_array'];
            // 画像URLの拡張子チェック
            if (isset($csv_array)) {
                foreach ($csv_array as $csv) {
                    $extends = substr($csv['image_url'], mb_strrpos($csv['image_url'], "."));
                    // .jpeg, .jpg, .png以外はエラーとする
                    if (!Str::contains($extends, ['.jpeg', '.jpg', '.png'])) {
                        $validator->errors()->add('image_url', '画像URLにはjpeg、pngの画像のみ指定してください。');
                    };
                }
            }
        });
    }
}
