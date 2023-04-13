<?php

session_start();

require 'connect/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: ' . ROOT . 'auth.php');
} else if ($_SESSION['user']['role'] == 'admin') {
    header('Location: ' . ROOT . 'admin');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajax Upload</title>

    <script src="/qqb-ca/assets/jquery.min.js"></script>
    <script src="/qqb-ca/assets/semantic.min.js"></script>

    <link rel="stylesheet" href="/qqb-ca/assets/semantic.min.css" />
</head>

<body>
    <div class="ui container">
        <a class="ui tiny right floated red button" href="/">
            Выйти
        </a>
        <div class="ui text menu">
            <div class="item" style="width:72px;height:72px;margin-right:48px;">
                <img style="width:72px;height:72px;" src="/qqb-ca/assets/logo_qqb.jpg">
            </div>
            <div class="ui item">
                <div style="text-align:left;">
                    <div style="display:block;">
                        <p>Банк: <a href="#"><b>ТОШКЕНТ Ш., АТБ "КИШЛОК КУРИЛИШ БАНК" БОШ АМАЛИЁТЛАР</b></a></p>
                    </div>
                    <br>
                    <div style="display:block;">
                        <p>Клиент: <a href="#"><b><?php echo $_SESSION['user']['username']; ?> <?php echo $_SESSION['user']['name']; ?></a></b></p>
                    </div>
                </div>
            </div>
            <div class="ui item">
                <div style="text-align:left;">
                    <div style="display:block;">
                        <p>Операционный день: <b>31.03.2023</b> <span class="ui black horizontal label">Открыт</span></p>
                    </div>
                    <br>
                    <div style="display:block;">
                        <p>Дата последнего входа: <span class="ui black horizontal label">31.03.2023 16:46:53</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="ui fluid ordered steps">
            <div class="active step" id="firstStep">
                <div class="content">
                    <div class="title">Тип кредита</div>
                    <div class="description">Choose your shipping options</div>
                </div>
            </div>
            <div class="step" id="secondStep">
                <div class="content">
                    <div class="title">Данные</div>
                    <div class="description">Enter billing information</div>
                </div>
            </div>
            <div class="step" id="thirdStep">
                <div class="content">
                    <div class="title">Документы</div>
                    <div class="description">Verify order details</div>
                </div>
            </div>
        </div>

        <div class="ui divider"></div>

        <div class="creditType">
            <div class="ui link cards" style="display:flex;flex-direction:row;justify-content:center;flex-wrap:wrap;">
                <?php $types = R::findAll('ctypes'); ?>
                <?php foreach ($types as $type) : ?>
                    <div class="card" id="<?php echo $type['id']; ?>">
                        <div class="image">
                            <img src="/qqb-ca/assets/img11.jpg">
                        </div>
                        <div class="content">
                            <div class="header"><?php echo $type['name']; ?></div>
                            <div class="meta">
                                <a>Тип кредита</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="ui huge form sendForm">
            <div class="ui fluid field">
                <label>Причина кредита</label>
                <input id="cr_purpose" type="text">
            </div>
            <div class="ui fluid field">
                <label>Сумма кредита</label>
                <input id="cr_sum" type="number">
            </div>
            <div class="ui fluid field">
                <label>Период кредита</label>
                <input id="cr_period" type="number">
            </div>

            <button class="huge ui fluid button black" id="send">Далее</button>
        </div>

        <div class="ui huge form uploadForm">
            <div class="ui fluid field">
                <label class="docLabel">Сотиб олиш буйича шартномани юклаш <span class="ui green text" id="cr_file_1_check"></span></label>
                <div class="ui fluid fields" style="display:flex;justify-content:space-between;" id="uploadField">
                    <div class="fourteen wide field">
                        <div class="ui file action input">
                            <input id="cr_file_1" class="docInput" type="file">
                            <label id="cr_file_1_label" for="cr_file_1" class="ui huge black button docInputLabel">
                                Выбрать
                            </label>
                        </div>
                    </div>
                    <div class="two wide field">
                        <button class="ui huge button" id="cr_file_1_button" onclick="uploadFileAjax('cr_file_1');">Загрузить</button>
                    </div>
                </div>
            </div>
            <div class="ui fluid field">
                <label class="docLabel">Молиявий хисоботларни юклаш <span class="ui green text" id="cr_file_2_check"></span></label>
                <div class="ui fluid fields" style="display:flex;justify-content:space-between;" id="uploadField">
                    <div class="fourteen wide field">
                        <div class="ui file action input">
                            <input id="cr_file_2" class="docInput" type="file">
                            <label id="cr_file_2_label" for="cr_file_2" class="ui huge black button docInputLabel">
                                Выбрать
                            </label>
                        </div>
                    </div>
                    <div class="two wide field">
                        <button class="ui huge button" id="cr_file_2_button" onclick="uploadFileAjax('cr_file_2');">Загрузить</button>
                    </div>
                </div>
            </div>
            <div class="ui fluid field">
                <label class="docLabel">Кредит таъминотига такдим этиладиган мулклар <span class="ui green text" id="cr_file_3_check"></span></label>
                <div class="ui fluid fields" style="display:flex;justify-content:space-between;" id="uploadField">
                    <div class="fourteen wide field">
                        <div class="ui file action input">
                            <input id="cr_file_3" class="docInput" type="file">
                            <label id="cr_file_3_label" for="cr_file_3" class="ui huge black button docInputLabel">
                                Выбрать
                            </label>
                        </div>
                    </div>
                    <div class="two wide field">
                        <button class="ui huge button" id="cr_file_3_button" onclick="uploadFileAjax('cr_file_3');">Загрузить</button>
                    </div>
                </div>
            </div>
            <div class="ui fluid field">
                <label class="docLabel">Лойиха буйича ишлаб чикилган ТИА (бизнес режа) <span class="ui green text" id="cr_file_4_check"></span></label>
                <div class="ui fluid fields" style="display:flex;justify-content:space-between;" id="uploadField">
                    <div class="fourteen wide field">
                        <div class="ui file action input">
                            <input id="cr_file_4" class="docInput" type="file">
                            <label id="cr_file_4_label" for="cr_file_4" class="ui huge black button docInputLabel">
                                Выбрать
                            </label>
                        </div>
                    </div>
                    <div class="two wide field">
                        <button class="ui huge button" id="cr_file_4_button" onclick="uploadFileAjax('cr_file_4');">Загрузить</button>
                    </div>
                </div>
            </div>
            <div class="ui fluid field">
                <label class="docLabel">Таъсис хужжатлари <span class="ui green text" id="cr_file_5_check"></span></label>
                <div class="ui fluid fields" style="display:flex;justify-content:space-between;" id="uploadField">
                    <div class="fourteen wide field">
                        <div class="ui file action input">
                            <input id="cr_file_5" class="docInput" type="file">
                            <label id="cr_file_5_label" for="cr_file_5" class="ui huge black button docInputLabel">
                                Выбрать
                            </label>
                        </div>
                    </div>
                    <div class="two wide field">
                        <button class="ui huge button" id="cr_file_5_button" onclick="uploadFileAjax('cr_file_5');">Загрузить</button>
                    </div>
                </div>
            </div>
            <div class="ui fluid field">
                <label class="docLabel">Шартнорма, кадастр ва эксперт хужжатлари <span class="ui green text" id="cr_file_6_check"></span></label>
                <div class="ui fluid fields" style="display:flex;justify-content:space-between;" id="uploadField">
                    <div class="fourteen wide field">
                        <div class="ui file action input">
                            <input id="cr_file_6" class="docInput" type="file">
                            <label id="cr_file_6_label" for="cr_file_6" class="ui huge black button docInputLabel">
                                Выбрать
                            </label>
                        </div>
                    </div>
                    <div class="two wide field">
                        <button class="ui huge button" id="cr_file_6_button" onclick="uploadFileAjax('cr_file_6');">Загрузить</button>
                    </div>
                </div>
            </div>
            <button class="huge ui fluid button black" id="upload">Далее</button>
        </div>


        <div class="completedText">
            <h1>Все верно заполнено?</h1>

            <p>Тип кредита: <span id="preview-cr-type"></span></p><br>
            <p>Причина кредита: <span id="preview-cr-purpose"></span></p><br>
            <p>Сумма кредита: <span id="preview-cr-sum"></span></p><br>
            <p>Период кредита: <span id="preview-cr-period"></span></p><br>

            <button class="ui red button" id="cancel_button">Отменить</button>
            <button class="ui green button" id="confirm_button">Отправить</button>
        </div>
    </div>

    <script>
        let creditType;

        let uploadedCount = 0;

        $('.uploadForm').hide();
        $('.sendForm').hide();
        $('.completedText').hide();

        let credit_id;

        let data;

        $('.card').on('click', function() {
            creditType = $(this).attr('id');

            $('.sendForm').show();
            $('.creditType').hide();

            $('#firstStep').removeClass('active');
            $('#firstStep').addClass('completed');
            $('#secondStep').addClass('active');
        });

        function uploadFileAjax(text) {
            if ($('#' + text).val() != '') {
                let file_data = $('#' + text).prop('files')[0];
                let form_data = new FormData();
                form_data.append('file', file_data);
                form_data.append('cr_id', credit_id);
                form_data.append('db_alias', text);
                $.ajax({
                    url: 'upload.php', // <-- point to server-side PHP script 
                    dataType: 'text', // <-- what to expect back from the PHP script, if anything
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: form_data,
                    type: 'post',
                    beforeSend: function() {
                        $('#' + text + '_button').addClass('loading');
                    },
                    success: function(php_script_response) {
                        $('#' + text).attr('disabled', 'disabled');
                        $('#' + text + '_button').attr('disabled', 'disabled');
                        $('#' + text + '_label').addClass('disabled');
                        $('#' + text + '_button').removeClass('loading');
                        $('#' + text + '_check').html('(Юкланди)');
                        uploadedCount++;
                    }
                });
            } else {
                alert2('Сначала выберите документ!');
            }
        }

        $('#send').on('click', function() {
            if ($('#cr_purpose').val() != '' && $('#cr_sum').val() != '' && $('#cr_period').val() != '') {
                data = {
                    cr_type: creditType,
                    cr_purpose: $('#cr_purpose').val(),
                    cr_sum: $('#cr_sum').val(),
                    cr_period: $('#cr_period').val()
                };

                $.ajax({
                    url: 'send.php', // <-- point to server-side PHP script 
                    dataType: 'text',
                    data: data,
                    type: 'post',
                    success: function(php_script_response) {
                        credit_id = php_script_response;

                        $('.uploadForm').show();
                        $('.sendForm').hide();

                        $('#secondStep').removeClass('active');
                        $('#secondStep').addClass('completed');
                        $('#thirdStep').addClass('active');
                    }
                });
            } else {
                alert2('Сначала заполните все!');
            }
        });

        $('#cancel_button').on('click', function() {
            window.location.href = '<?php echo ROOT; ?>';
        });

        $('#confirm_button').on('click', function() {
            $.ajax({
                url: 'confirm.php', // <-- point to server-side PHP script 
                dataType: 'text',
                data: {
                    id: credit_id
                },
                type: 'post',
                success: function(php_script_response) {
                    alert2('Отправлено!');

                    window.location.href = '<?php echo ROOT; ?>';
                }
            });
        });

        $('#upload').on('click', function() {
            if (uploadedCount < 6) {
                alert2('Загрузите все документы!');
            } else {
                $('#thirdStep').removeClass('active');
                $('#thirdStep').addClass('completed');

                $('#preview-cr-type').html(data.cr_type);
                $('#preview-cr-purpose').html(data.cr_purpose);
                $('#preview-cr-sum').html(data.cr_sum);
                $('#preview-cr-period').html(data.cr_period);
                $('.completedText').show();
                $('.uploadForm').hide();
            }
        });

        $('.selection').dropdown();

        function alert2(text) {
            $.toast({
                class: 'error',
                position: 'top attached',
                message: text
            });
        }
    </script>
</body>

</html>