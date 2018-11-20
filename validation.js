@if ($errors->any())
$.notify({
    icon: "ti-na",
    message: "{{ __('Validation Failed.') }}"

},{
    type: 'danger',
    timer: 10000,
    placement: {
        from: 'top',
        align: 'center'
    }
});

const validatedFormIdentifier = '{{old('_identifier')}}';

$('.content form').each(function () {
    let validator = $(this).data('validation');
    let identifier = $(this).data('identifier');
    if (validator && identifier == validatedFormIdentifier) {
        $(this).data('validation').showErrors({
        @foreach ($errors->toArray() as $key => $value)
        '{{ $key }}': '{{ implode(' ', $value) }}',
        @endforeach
        });
    }
})
@endif