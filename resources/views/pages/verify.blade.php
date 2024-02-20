@extends('layout.app')

@section('content')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
    <section class="section-4">
        <div class="card pd-24px---18px text-center">
            <h3 class="text-200 bold">Введите код из СМС</h3>
            <p>На номер <span class="text-span-3">{{request()->get('verify')['phone']}}</span> отправлен СМС-код для подтверждения контактных данных в Вашей анкете</p>
            <div class="change_number"><button style="background: transparent" onclick="openChangeNumber()">Изменить номер телефона?</button></div>
            <div class="form-block w-form">
                <form id="verify-form" action="{{route('form.phone.verify')}}" method="post" class="form">
                    @csrf
                    <div class="wrap_sms">
                        <input type="hidden" name="phone" value="{{ request()->get('verify')['phone'] ?? null}}">
                        <input class="text-field w-input code-input" type="number" name="code" required>
                        <input class="text-field w-input code-input" type="number" name="code" required>
                        <input class="text-field w-input code-input" type="number" name="code" required>
                        <input class="text-field w-input code-input" type="number" name="code" required>
                        <input type="hidden" name="full_code" id="full_code">
                    </div>
                </form>
                @include('inc.alert')
            </div>
            <div class="text-block-2">Отправить повторно через: <span class="text-span-4" id="link">00: <span id="seconds">59</span></span></div>
            <div class="buttons-row center gap-column-12px">
                <div>
                    <a href="#" class="btn-secondary w-inline-block">
                        <div class="flex-horizontal gap-column-4px">
                            <div>Cancel</div>
                        </div>
                    </a>
                </div>
                <a href="#" class="btn-primary w-inline-block" onclick="onSubmit()">
                    <div class="flex-horizontal gap-column-4px">
                        <div>Подтвердить</div><img src="{{ asset('images/primary-button-icon-right-dashflow-webflow-template.svg')}}" loading="eager" alt="" class="link-icon arrow-right">
                    </div>
                </a>
            </div>
        </div>
    </section>

        <section class="end_offer" id="changeNumber" >
        <div class="card pd-24px---18px text-center thank-you">
            <h3 class="text-200 bold">Изменить номер телефона</h3>
            <form method="post" action="{{route('form.changeNumber')}}" id="change-form">
                @csrf
                <input type="hidden" name="old_number" value="{{request()->get('verify')['phone']}}">
                <input type="text" class="input w-input" name="phone" id="phone-mask" value="77" required>
            </form>

            <div class="buttons-row center gap-column-12px" style="margin-top: 15px">
                <div>
                    <a style="display: flex" data-w-id="5228fae3-1046-92bf-afc3-a85185c5a451" href="#" onclick="closeChangeNumber()" class="btn-secondary w-inline-block" >
                        <div class="flex-horizontal gap-column-4px">
                            <div>Отмена</div>
                        </div>
                    </a>
                </div>
                <button href="#" class="btn-primary w-inline-block" onclick="return document.getElementById('change-form').submit()">
                    <div class="flex-horizontal gap-column-4px">
                        <div>Изменить</div><img src="{{ asset('images/primary-button-icon-right-dashflow-webflow-template.svg')}}" loading="eager" alt="" class="link-icon arrow-right">
                    </div>
                </button>
            </div>
        </div>
    </section>

    <section class="end_offer" style="display: @if(Session::has('success')) flex @else none @endif">
        <div class="card pd-24px---18px text-center thank-you">
            <div class="mg-bottom-24px">
                <div class="lottie-animation" data-w-id="edd9ce26-9006-8e8b-ae30-cd7313500cea" data-animation-type="lottie" data-src="{{ asset('documents/OYdCpYSwMy.json')}}" data-loop="0" data-direction="1" data-autoplay="1" data-is-ix2-target="0" data-renderer="svg" data-default-duration="1.1666666666666667" data-duration="0"></div>
            </div>
            <h3 class="text-200 bold">Ваша анкета отправлена!</h3>
            <p class="paragraph-7">В течении 30 минут Вам будут поступать предложения от наших партнеров. <br>Удачных сделок!</p>
            <div class="buttons-row center gap-column-12px">
                <div>
                    <a data-w-id="5228fae3-1046-92bf-afc3-a85185c5a451" href="#" class="btn-secondary w-inline-block">
                        <div class="flex-horizontal gap-column-4px">
                            <div>Cancel</div>
                        </div>
                    </a>
                </div>
                <a data-w-id="edd9ce26-9006-8e8b-ae30-cd7313500cf4" href="/" class="btn-primary w-inline-block">
                    <div class="flex-horizontal gap-column-4px">
                        <div>Спасибо!</div><img src="{{ asset('images/primary-button-icon-right-dashflow-webflow-template.svg')}}" loading="eager" alt="" class="link-icon arrow-right">
                    </div>
                </a>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        const inputElements = [...document.querySelectorAll('input.code-input')]

        inputElements.forEach((ele,index)=>{
            ele.addEventListener('keydown',(e)=>{
                // if the keycode is backspace & the current field is empty
                // focus the input before the current. Then the event happens
                // which will clear the "before" input box.
                if(e.keyCode === 8 && e.target.value==='') inputElements[Math.max(0,index-1)].focus()
            })
            ele.addEventListener('input',(e)=>{

                const [first,...rest] = e.target.value
                e.target.value = first ?? '' // first will be undefined when backspace was entered, so set the input to ""
                const lastInputBox = index===inputElements.length-1
                const didInsertContent = first!==undefined
                if(didInsertContent && !lastInputBox) {
                    // continue to input the rest of the string
                    inputElements[index+1].focus()
                    inputElements[index+1].value = rest.join('')
                    inputElements[index+1].dispatchEvent(new Event('input'))
                }
            })
        })


        // mini example on how to pull the data on submit of the form
        function onSubmit(){
            const code = inputElements.map(({value})=>value).join('')
            console.log(code)
            document.getElementById('full_code').value = code
            document.getElementById('verify-form').submit()
        }

        let timeleft = 5;
        let seconds = 1;
        let downloadTimer = setInterval(function(){
            if(timeleft === seconds){
                clearInterval(downloadTimer);
                document.getElementById("link").innerHTML = '<form action="/form/submit/resend" method="post" style="text-decoration: none" class="text-span-4">@csrf
                    <input type="hidden" name="phone" value="{{request()->get('verify')['phone']}}"> <button style="background: transparent">Отправить</button></form>';
            }

            document.getElementById("seconds").innerHTML = twoDigits(timeleft - seconds);
            seconds++;
        }, 1000);

        function twoDigits(n){
            return (n < 10 ? "0" : "") + n;
        }

        function closeChangeNumber() {
            $('#changeNumber').css('display', 'none');
        }
        function openChangeNumber() {
            $('#changeNumber').css('display', 'flex');

        }
    </script>
@endsection
