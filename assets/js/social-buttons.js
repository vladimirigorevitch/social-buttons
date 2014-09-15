;
    var likesWrapperCreate = function () {

        return $('<div class="likes-wrapper"></div>');
    };  //  end of likesWrapperCreate

    // создает элемент DOM дерева - кнопку 'like' для указанной соц. сети.
    // аргументы: 1. Название соц.сети (String: 'facebook', 'google', 'tweeter', 'vkontakte');
    // 2. Количество 'лайков' (Integer >= 0), не обязательный, устанавливается в 0 по умолчанию или при ошибке.
    //TODO: непонятный баг с отступами; добавить систему "лайков";
    var socialButtonCreate = function (socNetName, likesCount) {

        var argLength = arguments.length;
        if (!argLength) {
            return false;
        }

        var validNames = 'facebook fb tweeter tw vkontakte vk google g+ gp google+ googleplus';
        var newButton, icon, title, counter;

        socNetName = socNetName.toLowerCase().trim();
        if (validNames.indexOf(socNetName) >= 0) {

            if (socNetName === 'fb') socNetName = 'facebook';
            else if (socNetName === 'tw') socNetName = 'tweeter';
            else if (socNetName === 'vk') socNetName = 'vkontakte';
            else if ('gp google+ googleplus g+'.indexOf(socNetName) >= 0) socNetName = 'google';

            newButton = $('<div class=\"social-button social-icons\"></div>').attr('id', 'social-' + socNetName);
            icon = $('<span></span>').addClass('social-icon-' + socNetName).css('margin-right', '2px');
            title = $('<span></span>').addClass('social-title-' + socNetName);
            counter = $('<span class="social-counter"></span>');

            if (argLength > 1) {     // parsing 2nd argument
                if ( !(Number.isInteger(likesCount))) {
                    likesCount = parseInt(likesCount, 10);
                }
                if (likesCount < 0 || isNaN(likesCount)) {
                    likesCount = 0;
                }
            } else {
                likesCount = 0;
            }

            counter.text(likesCount.toString()).css('margin-left', '9px');  // margin-left: 7px; -by default

            return newButton.append(icon).append(title).append(counter);
        }
        else {
            return false;
        }
    };  // end of socialButtonCreate
