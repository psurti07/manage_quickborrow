<div class="modal fade" id="remarketingLogDetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $data->crontype }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <dl class="row">
                        <dd class="col-md-4">Date - Time :</dd>
                        <dt class="col-md-8">{{ date('d-m-Y h:i:s A', strtotime($data->rec_date)) }}</dt>
                    </dl>
                    <hr/>
                    <dl class="row">
                        <dd class="col-md-4">Msg For :</dd>
                        <dt class="col-md-8">{{ $data->crontype }}</dt>
                    </dl>
                    <hr/>
                    <dl class="row">
                        <dd class="col-md-4">Job Name :</dd>
                        <dt class="col-md-8">{{ $data->cronname }}</dt>
                    </dl>
                    <hr/>
                    <dl class="row">
                        <dd class="col-md-4">Total Messages :</dd>
                        <dt class="col-md-8">{{ $data->msgcount }}</dt>
                    </dl>
                    <hr/>
                    <dl class="row">
                        <dd class="col-md-12">Response :</dd>
                        <dt class="col-md-12">
                            <code>{!! $data->msgresponse !!}</code>
                        </dt>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
