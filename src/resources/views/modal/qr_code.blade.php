
<div class="qr-container">
  <div class="qr-body">
    <div class="qr-close">×</div>
    <div class="qr-content">
      {!! QrCode::size(200)->encoding('UTF-8')->generate('reserve '.$reserve['id'].',user '.$user['name']) !!}
    </div>
  </div>
</div>
