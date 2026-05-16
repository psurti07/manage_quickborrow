@if($userData)
<div class="row g-3">
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="module" class="fw-bold me-2 mb-0">Module:</label>
        <span id="module">
            @if($userData->acc_type == 1)
            Self Apply
            @elseif($userData->acc_type == 2)
            Loan Agent
            @else
            -
            @endif
        </span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="mobile" class="fw-bold me-2 mb-0">Mobile:</label>
        <span id="mobile">{{ $userData->mobile ?? '-' }}</span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="date" class="fw-bold me-2 mb-0">Date:</label>
        <span id="date">{{ date('d-m-Y h:i:s',strtotime($userData->rec_date)) ?? '-' }}</span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="fullname" class="fw-bold me-2 mb-0">Fullname:</label>
        <span id="fullname">
            @if($userData->first_name || $userData->last_name)
            {{ $userData->first_name ?? '-' }} {{ $userData->last_name ?? '-' }}
            @else
            -
            @endif
        </span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="email" class="fw-bold me-2 mb-0">Email ID:</label>
        <span id="email">{{ $userData->email ?? '-' }}</span>
    </div>
    <div class="col-md-12 d-flex align-items-center border p-3 rounded">
        <label for="fullname" class="fw-bold me-2 mb-0">Source:</label>
        @if($userData->isUser == 1 && $userData->isDelete == 0)
            <span id="fullname" class="text-warning">Data as a Company Lead.</span>
        @elseif($userData->isUser == 2 && $userData->isDelete == 0)
            <span id="fullname" class="text-success">Registred as a customer.</span>
        @elseif($userData->isDelete == 1)
            <span id="fullname" class="text-danger">Account is deleted.</span>
        @else
        
        @endif
    </div>
    <div class="col-12 mt-3">
        @if($userData->acc_type == 1)
            @if($userData->isUser == 1 && $userData->isDelete == 0)
                <a href="{{ route('manage.selfapply.company.leads') }}">
                    <button type="submit" id="submit" class="btn btn-outline-primary">More Details</button>
                </a>
            @elseif($userData->isUser == 2 && $userData->isDelete == 0)
                <a href="{{ route('manage.selfapply.customer.details',$userData->id) }}">
                    <button type="submit" id="submit" class="btn btn-outline-primary">More Details</button>
                </a>
            @else
                <a href="javascript:;">
                    <button type="submit" id="submit" class="btn btn-outline-primary" disabled>More Details</button>
                </a>
            @endif
        @elseif($userData->acc_type == 2)
            @if($userData->isUser == 1 && $userData->isDelete == 0)
                <a href="{{ route('manage.loanagent.company.leads') }}">
                    <button type="submit" id="submit" class="btn btn-outline-primary">More Details</button>
                </a>
            @elseif($userData->isUser == 2 && $userData->isDelete == 0)
                <a href="{{ route('manage.loanagent.customer.details',$userData->id) }}">
                    <button type="submit" id="submit" class="btn btn-outline-primary">More Details</button>
                </a>
            @else
                <a href="javascript:;">
                    <button type="submit" id="submit" class="btn btn-outline-primary" disabled>More Details</button>
                </a>
           @endif
        @endif
    </div>
</div>
@else
<div class="card-body p-0">
    <p class="text-center text-danger">No data available.</p>
</div>
@endif
