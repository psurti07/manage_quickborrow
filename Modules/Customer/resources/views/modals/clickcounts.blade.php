<div class="modal fade" id="clickCountsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Click Counts</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <p class="text-center"><img src="{{ asset('upload/banks/'.$bank->bank_image) }}" alt="{{ $bank->bank_name }}" width="100"></p>
                    <hr/>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <th>#</th>
                                    <th>Clicked Events</th>
                                </thead>
                                <tbody>
                                    @if($counts->isNotEmpty())
                                        @foreach($counts as $count)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ date('d-m-Y h:i:s A', strtotime($count->rec_date)) }}</td>
                                        </tr>
                                        @endforeach
                                        <tr>
                                            <td><strong>Total Clicks</strong></td>
                                            <td><strong>{{ count($counts) }}</strong></td>
                                        </tr>
                                    @else
                                    <tr>
                                        <td  colspan="2" class="text-center">No activity.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Total Clicks</strong></td>
                                        <td><strong>0</strong></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
