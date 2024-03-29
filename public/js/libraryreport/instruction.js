//Test Vue.JS

const app = new Vue({
    el: '#app',
    data: {
        
    },
    methods: {
        downWord() {
            var link = document.createElement('a');
            var btn = document.createElement('button');
            link.setAttribute('href', "http://elios.ugrasu.ru/instruction/LibraryReport2019.docx");
            btn.addEventListener('click', this.simulateClick(link));
        },

        downPDF() {
            var link = document.createElement('a');
            var btn = document.createElement('button');
            link.setAttribute('href', "http://elios.ugrasu.ru/instruction/LibraryReport2019.pdf");
            btn.addEventListener('click', this.simulateClick(link));
        },

        //Для совместимости с Firefox симулируем нажатие кнопки мыши
        //Ссылка на документацию: https://developer.mozilla.org/ru/docs/Web/API/MouseEvent
        simulateClick(link) {
            var evt = new MouseEvent("click");
            setTimeout(() => {
                link.dispatchEvent(evt);
            }, 500);
        },

    }
});