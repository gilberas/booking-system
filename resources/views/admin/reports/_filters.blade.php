<form method="GET" class="card mb-3">
    <div class="card-body">
        <div class="row g-2 align-items-end">
            <div class="col-auto">
                <label class="form-label small">From</label>
                <input type="date" name="from" class="form-control form-control-sm" value="{{ $from }}">
            </div>
            <div class="col-auto">
                <label class="form-label small">To</label>
                <input type="date" name="to" class="form-control form-control-sm" value="{{ $to }}">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-sm btn-navy">Filter</button>
                <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-navy">Reset</a>
            </div>
        </div>
    </div>
</form>
