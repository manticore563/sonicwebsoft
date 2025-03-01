<h4 class="mb-3">@lang('common.provideCreditCardInfo')</h4>
<div class="col-md-12">
    <div class="form-group mb-3">
        <label class="form-label" for="cc-name">@lang('common.nameOnCard')</label>
        <input type="text" class="form-control" id="cc-name" placeholder="" required name="name_card">
        <small class="text-muted">@lang('common.fullnameOnCard')</small>
        <div class="invalid-feedback">{{ $errors->first('name_card') }}</div>
    </div>
</div>
<div class="col-md-12">
    <input type="hidden" id="client_token" value="{{ $client_token ?? '' }}">
    <div id="card-element" class="border rounded p-3"></div>
</div>
