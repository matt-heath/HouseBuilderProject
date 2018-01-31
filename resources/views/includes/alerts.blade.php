{{--<script src="{{asset('js/libs.js')}}"></script>--}}

{{-- Bootstrap Notifications using Prologue Alerts --}}
<script type="text/javascript">
    jQuery(document).ready(function($) {

        PNotify.prototype.options.styling = "bootstrap3";
        PNotify.prototype.options.styling = "fontawesome";

        @foreach (Alert::getMessages() as $type => $messages)
            @foreach ($messages as $message)

            $(function(){
                new PNotify({
                    // title: 'Regular Notice',
                    text: "{{ $message }}",
                    type: "{{ $type }}",
                    icon: false,
                    mouse_reset: false,
                    closer_hover: true

                });
            });

            @endforeach
        @endforeach
    });
</script>