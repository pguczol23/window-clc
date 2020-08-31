jQuery(function($){

    let Calculator = {
        type: 1,
        sumField: $('.form-container .bl_left span'),
        optionsEls: $('.form-container .oc_line .checkbox input'),
        typesContainerEls: $(".base-container .type-container"),
        currentContainer: null,
        typesWindow: $(".window-menu .type-window"),
        currentTypes: null,
        activeType: null,
        needOtl: false,
        needMon: false,
        maket: $('.form-container .maket img'),
        data: {$_DATA_PATTERN_$},
        onClick: (e) => {
            const self = Calculator;
            const el = $(e.currentTarget);
            const index = self.currentContainer.find(el).index();

            if (index === self.activeType) {
                return;
            }

            self.activeType = index;

            self.calculate();
        },
        onChange: (e) => {
            const self = Calculator;

            const el = $(e.target)[0];

            if (el.name === 'need_otliv') {
                self.needOtl = $(el).prop('checked');
            }else {
                self.needMon = $(el).prop('checked');
            }

            self.calculate();
        },
        calculate: () => {
            const self = Calculator;

            self.typesContainerEls.hide();
            self.currentContainer = $(self.typesContainerEls[self.type-1]);
            self.currentContainer.show();

            self.currentTypes = self.currentContainer.find('.window-menu .type-window');
            self.typesWindow.unbind('click');
            self.currentTypes.on('click', self.onClick);

            self.typesWindow.removeClass('active');

            const index = self.activeType;

            $(self.currentTypes[index]).addClass('active');

            let current = self.data[self.type][index];
            let sum = Number(current.value);
            if (self.needMon) {
                sum += Number(current.monvalue);
            }
            if (self.needOtl) {
                sum += Number(current.podvalue);
            }

            self.sumField.html(sum + ' Р.');

            self.maket.attr('src', current.mainimg);
            self.maket.attr('alt', current.alt);
        },
        init: () => {
            const self = Calculator;

            let radio = $(".choose-view .radio input");

            radio.on('change', (e) => {
                Calculator.type = Number($(e.target).val());
                Calculator.calculate();
            });

            self.optionsEls.on('change', self.onChange);

            self.activeType = 0;

            self.calculate();
        }
    };

    window.Calculator = Calculator;
    Calculator.init();
});