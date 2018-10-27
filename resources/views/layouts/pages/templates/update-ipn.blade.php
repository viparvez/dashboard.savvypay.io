  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <form name="ipn" id="editForm" method="POST" action="{{route('ipn.update',$ipn->api_user_id)}}">
          {{csrf_field()}}

          <input type="hidden" name="_method" value="put">

          <div class="form-group">
            <label>IPN URL:</label>
            <input type="text" name="web_service_url" value="{{$ipn->web_service_url}}" class="form-control">
          </div>

          <div class="form-group">
            <label>Phone:</label>
            <input type="text" name="phone" value="{{$ipn->phone}}" class="form-control">
          </div>

          <div class="form-group">
            <label>Email:</label>
            <input type="text" name="email" value="{{$ipn->email}}" class="form-control">
          </div>

          <div class="form-group">
            <label>Comment:</label>
            <textarea name="comment" value="{{$ipn->comment}}" class="form-control"></textarea>
          </div>

          <button class='btn btn-block btn-success btn-sm' id='submitEdit' type='submit'>SAVE</button>
          <button class='btn btn-block btn-success btn-sm' id='loadingEdit' style='display: none' disabled=''>Working...</button>

        </form>

      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </section>

