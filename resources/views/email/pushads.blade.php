<div style="font-size: 14px; color: black !important; font-family: Verdana, Arial, Helvetica, sans-serif !important; width: calc(100% - 50px); line-height: 150%;background-color: #f0f0f0;padding: 25px;">
  <div style="background-color: #ffffff !important; border: 1px solid #d8d8d8; width: 100%;">
      {{$body->title}}

    <div style="margin-bottom: 20px; text-align: center; padding: 5px 0;">
      @if(!empty($body->digital_assets))
        @foreach($body->digital_assets as $file)
          <div><img src="{{$file->getUrl()}}" style="width: 300px; margin: -5px 0;"></div>
        @endforeach
      @endif
    </div>

    <div style="text-align: center; margin-bottom: 40px;">
      <div style="text-align: center; margin-bottom: 20px; font-size: 16px;">
        {!! $body->subject !!}
      </div>
      <div style="text-align: center;">
        <a href="{{$body->link}}" style="background-color: #7367F0; border-radius: 4px; padding: 15px 20px; color: white; font-weight: bold; text-decoration: none;">Know More</a>
      </div>
    </div>

    <div style="text-align: center; background-color: #f0f0f0; border-top: 1px solid #d8d8d8; font-size: 12px; color: #8b8b8b; padding: 15px;">
      <p>This is a system generated email, please do not reply to this email.</p>
    </div>
  </div>
</div>
