@extends('layout.app')
<style>
    .photo_download {
        overflow: scroll;
        overflow-x: hidden;
    }
    ::-webkit-scrollbar {
        width: 0;  /* Remove scrollbar space */
        background: transparent;  /* Optional: just make scrollbar invisible */
    }
    /* Optional: show position indicator in red */
    ::-webkit-scrollbar-thumb {
        background: #FF0000;
    }
    .dropzone{
        border: 1px solid var(--neutral--400) !important;
    }
    .dz-message{
        display: none;
    }
</style>
@section('content')
    {{ print_r($errors) }}
    <section class="main-section">
        <div class="w-layout-blockcontainer container-default w-container">
            <div data-w-id="62ced0c3-c9fd-061c-0030-ba2c6aea3963" style="opacity:1" class="card image-right-inside form_block">
                <h1 class="text-500 bold header">Анкета</h1>
                <p class="paragraph offer">Постарайтесь предоставить максимально подробную и достоверную информацию, для точной предварительной оценки. <br></p>
                <h2 class="text-500 bold">Об автомобиле</h2>
                <form id="form" method="post" action="{{route('form.submit')}}" enctype="multipart/form-data">
                    @csrf
                    <div id="w-node-a1562852-76da-54aa-c2b3-6783085eacf0-af954baa" class="w-form">

                        <div class="w-layout-grid offer_grid">
                                <div>
                                    <label class="field-label">Марка автомобиля</label>
                                    <div><input class="input w-input" name="mark" type="text" required=""></div>
                                </div>
                                <div><label for="Name-3" class="field-label">Модель автомобиля</label>
                                    <div><input class="input w-input" name="model" type="text" required=""></div>
                                </div>
                                <div><label for="Name-3" class="field-label">Год выпуска</label>
                                    <div><input class="input w-input" name="year" type="number" step="1" min="1960" max="2024" required=""></div>
                                </div>
                                <div><label for="Name-5" class="field-label">Пробег (км)</label>
                                    <div><input class="input w-input" name="mileage" type="number" required=""></div>
                                </div>
                                <div><label for="Name-6" class="field-label">Объем двигателя (л)</label>
                                    <div><input class="input w-input" name="capacity" step="0.1" type="number" required=""></div>
                                </div>
                                <div>
                                    <label for="field-16" class="field-label">Тип двигателя</label>
                                        <select id="field-16" name="engine_type" required="" class="dropdown-toggle faq w-select">
                                        <option value=""></option>
                                        <option value="Бензин">Бензин</option>
                                        <option value="Дизель">Дизель</option>
                                        <option value="Электродвигатель">Электродвигатель</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="field-17" class="field-label">Тип АКПП</label>
                                    <select id="field-17" name="transmission_type" required="" class="dropdown-toggle faq w-node-_286d4674-0e1a-3cb8-b200-7826c78bd72d-af954baa w-select">
                                        <option value=""></option>
                                        <option value="Автомат">Автомат</option>
                                        <option value="Механика">Механика</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="field-18" class="field-label">Привод</label>
                                    <select id="field-18" name="drive_unit" required="" class="dropdown-toggle faq w-node-_1c5163eb-0756-c713-290c-487bac364ac0-af954baa w-select">
                                        <option value=""></option>
                                        <option value="Передний">Передний</option>
                                        <option value="Задний">Задний</option>
                                        <option value="Полный">Полный</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="field-11" class="field-label">Цвет</label>
                                    <select id="field-11" name="color" required="" class="dropdown-toggle faq w-node-_629d6750-c899-1af1-27aa-6d2e39be46f9-af954baa w-select">
                                        <option value=""></option>
                                        <option value="Белый">Белый</option>
                                        <option value="Черный">Черный</option>
                                        <option value="Серебристый">Серебристый</option>
                                        <option value="Синий">Синий</option>
                                        <option value="Желтый">Желтый</option>
                                        <option value="Зеленый">Зеленый</option>
                                        <option value="Фиолетовый">Фиолетовый</option>
                                        <option value="Красный">Красный</option>
                                        <option value="Серый">Серый</option>
                                        <option value="Коричневый">Коричневый</option>
                                        <option value="Оранжевый">Оранжевый</option>
                                        <option value="Розовый">Розовый</option>
                                        <option value="Бежевый">Бежевый</option>
                                        <option value="Золотистый">Золотистый</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="field-13" class="field-label">Состоит в аресте?</label>
                                    <select id="field-13" name="arrested" required="" class="dropdown-toggle faq w-node-d0b16591-0903-fe2e-02cd-14e31e8ab249-af954baa w-select">
                                        <option value=""></option>
                                        <option value="0">Нет</option>
                                        <option value="1">Да</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="field-15" class="field-label">Состоит в залоге?</label>
                                    <select id="field-15" name="pledged" required="" class="dropdown-toggle faq w-node-_89733057-db7c-b257-ce88-5eb2d650291c-af954baa w-select">
                                        <option value=""></option>
                                        <option value="1">Нет</option>
                                        <option value="0">Да</option>
                                    </select></div>
                                <div>
                                    <label for="field-14" class="field-label">Растаможен в РК?</label>
                                    <select id="field-14" name="in_kz" data-name="Field 14" required="" class="dropdown-toggle faq w-node-c2efda82-0a4a-fb1e-2146-10c18721f94b-af954baa w-select">
                                        <option value=""></option>
                                        <option value="0">Нет</option>
                                        <option value="1">Да</option>
                                    </select></div>
                                <div>
                                    <label for="field-14" class="field-label">Состояние</label>
                                    <select id="field-14" name="crashed" required="" class="dropdown-toggle faq w-select">
                                        <option value=""></option>
                                        <option value="0">На ходу</option>
                                        <option value="1">Аварийное</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="field-14" class="field-label">Руль</label>
                                    <select id="field-14" name="right_hand" required="" class="dropdown-toggle faq w-node-_5310e603-c8db-2a4d-8a2c-7cb5cb93a3cb-af954baa w-select">
                                        <option value=""></option>
                                        <option value="0">Cлева</option>
                                        <option value="1">Cправа</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="field-20" class="field-label">VIN (не обязательно)</label>
                                    <input class="input w-input" minlength="17" maxlength="17" name="vin" type="text"
                                           onkeypress="return (event.charCode >= 65 && event.charCode <= 90) || (event.charCode >= 97 && event.charCode <= 122) || (event.charCode >= 48 && event.charCode <= 57)"
                                    >
                                </div>
                                <div>
                                    <label for="field-19" class="field-label">Комментарии (не обязательно)</label>
                                    <textarea maxlength="5000" id="field-19" name="comment" class="textarea w-input"></textarea>
                                </div>
                            </div>

                        <div class="w-form-fail">
                            <div class="error-message small">
                                <div class="flex align-center gap-column-4px"><img src="images/error-message-icon-dashflow-webflow-template.svg" loading="eager" alt="" class="max-w-12px">
                                    <div class="text-50 medium">Проверьте корректность данных</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-500 bold second_header">Фотографии автомобиля (не обязательно)</h2>
                    <p class="paragraph offer">Предоставьте фотографии с 4-х сторон автомобиля + фото салона + фото багажника. <br></p>
                    <div>
                        <div class="photo_download dropzone"
                             style="display: flex;
                                    flex-direction: column;
                                    flex-wrap: wrap;
                                    overflow: scroll;"
                             id="myDropzone">
                            <img src="{{ asset('images/icon-arrow.svg')}}" loading="lazy" alt="" id="drop-image" class="image">
                            <p class="paragraph-6" id="drop-paragraph">Нажмите для загрузки файлов <br>или перетащите файл в эту область</p>
                        </div>
                    </div>
                    <input type="file" style="display: none" multiple name="images[]" id="images-dropped">

                    <h2 class="text-500 bold second_header">Ваши контакты</h2>
                    <div class="w-form">
                        <div class="w-layout-grid contact_grid">
                            <div><label for="Name-3" class="field-label">Имя</label>
                                <div><input class="input w-input" name="name" required type="text" value="{{old('name')}}"></div>
                            </div>
                            <div><label for="Name-3" class="field-label">Номер телефона</label>
                                <div><input class="input w-input" name="phone" required id="phone-mask" type="tel" value="{{old('phone', '77')}}"></div>
                            </div>
                        </div>
                    </div>
                    <div class="div-block-4">
                        <button type="submit" onclick="file()" class="btn-primary w-inline-block">
                            <div class="flex-horizontal gap-column-4px">
                                <div>Отправить анкету</div><img src="images/primary-button-icon-right-dashflow-webflow-template.svg" loading="eager" alt="" class="link-icon arrow-right">
                            </div>
                        </button>
                        <p class="paragraph-4 privicy">Нажимая на кнопку, вы соглашаетесь c <a href="privacy-policy" target="_blank" class="link-3">политикой конфиденциальности</a> и <a href="offer" target="_blank" class="link-2">офертой</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section id="email" class="section-3">
        <div class="w-layout-blockcontainer container-default w-container">
            <div class="cta-card buy-card dark central">
                <div class="card-home-pages-wrapper">
                    <div class="div-block-5"><img src="images/Mail-icon.svg" alt="" class="cta-square-logo">
                        <h3 class="heading-2">У Вас есть вопросы или предложения?</h3>
                        <p class="paragraph-8">Напишите нам на почту, мы обязательно Вам ответим. </p>
                        <a href="mailto:info@xcar.kz?subject=%D0%9F%D1%80%D0%B5%D0%B4%D0%BB%D0%BE%D0%B6%D0%B5%D0%BD%D0%B8%D0%B5%20%D1%81%20%D1%81%D0%B0%D0%B9%D1%82%D0%B0" class="btn-primary w-inline-block">
                            <div class="flex-horizontal gap-column-4px">
                                <div>info@xcar.kz</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script>

    let formData = new FormData(document.getElementById('form'));
    let files = [];
    let dropzone = Dropzone.options.myDropzone = {
        url: "/fake/location",
        autoProcessQueue: false,
        paramName: "file",
        clickable: true,
        maxFilesize: 5, //in mb
        addRemoveLinks: true,
        dictDefaultMessage: '',
        acceptedFiles: '.png,.jpg',
        dictRemoveFile: "Удалить файл",
        init: function() {
            this.on("sending", function(file, xhr, formData) {
                console.log("sending file");
            });
            this.on("success", function(file, responseText) {
                console.log('great success');
            });
            this.on("addedfile", function(file){

                files.push(file)
                $('#drop-image').hide();
                $('#drop-paragraph').hide();
                $("#myDropzone").css('flex-direction', 'row')
                console.log('file added');

            });
            this.on("removedfile", function(file){
                files.pop(file)
                if(files.length == 0){
                    $('#drop-image').show();
                    $("#myDropzone").css('flex-direction', 'column')
                    $('#drop-paragraph').show();
                }

                console.log('file added: ' + files.length);

            });
        }
    };

    function file() {
        let fileInput = document.getElementById('images-dropped');
        let fileList = new DataTransfer();
        files.forEach(function (file) {
            fileList.items.add(file)
        })

        fileInput.files = fileList.files
    }
</script>
@endsection
