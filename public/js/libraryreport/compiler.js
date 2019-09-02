//Test Vue.JS

const app = new Vue({
    el: '#app',
    data: {
        page: null,                //Открытая страница

        //Данные для составления новых БС

        years: [],              //Года набора
        year: null,
        specialitys: [],        //Направления обучения
        speciality: null,
        speccode: null,
        forms: [],              //Формы обучения
        forma: null,
        disciplines: [],        //Дисциплины
        discipline: null,
        discode: null,
        fgoses: [],             //ФГОСы
        fgos: null,
        fnrec: null,            //Соответствующая запись в RPD
        studCount: null,        //Количество студентов
        studCoef: null,         //Коэффициет литературы на студента
        status: null,           //Статус составления БС
        full: 0,                //Полнота составляемой БС
        changed: {},            //Выбранные параметры
        //Данные поиска литературы
        search: {
            author: "Сафонов", //Автор
            title: "",  //Заглавие
            keyWords: "",   //Ключевые слова
            stopWords: "",  //Стоп слова
            filters: null,    //Фильтры
            result: null,  //Результаты
        },
        //Добавленная литература
        tBooks: [],
        eBooks: [],
        countAllBook: 0,
        countTBook: 0,
        countEBook: 0,
        countBBook: 0,
        countABook: 0,

        //Данные для отображения составленных БС
        listReports: [],        //Список библиографических спраок
        listEmpty: [],          //Список несоставленных библиографических справок
        listEmptyPage: 'empty',//
        report: [],             //Составленная БС
        edit: 0,                //Статус редактирования
        specialitysStarted: [], //Начатые специальности
        disciplinesStarted: []  //Начатые дисциплины
    },
    methods: {

        /* Методы секции заполнения парамметров 
        *
        *
        */
        //Загрузка направлений

        getStarted() {
            this.notifications('info', 'Началась загрузка начатых библиографических справок. Это может занять некоторое время. <b>Запаситесь терпением</b>', 100000);
            this.openPr();
            this.listReports = [];
            this.report = [];
            this.disciplinesStarted = [];
            this.fnrec = null;
            this.page = 0;
            this.select = null;
            $.ajax({
                url: '/libraryreport/libraryreport/getStartedByCompiler',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.specialitysStarted = JSON.parse(answer);
                    if (this.specialitysStarted !== 0) {
                        if (Object.keys(this.specialitysStarted).length > 0) {
                            this.notifications('success', 'Начатые библиографические справки успешно загружены!');
                        } else {
                            this.notifications('error', 'Начатые библиографическкие справки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске начатых справок');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке начатых библиографических справок!');
                },
                complete: () => {
                    this.closePr();
                }
            });
        },

        changeYear() {
            this.forma = null;
            this.speccode = null;
            this.year = this.changed.year;
            this.specialitys = [];
            this.changed.speccode = null;
            this.disciplines = [];
            this.changed.discode = null;
            this.forms = [];
            this.changed.forma = null;
            this.listReports = [];
            this.report = [];
            this.listEmpty = [];
            this.notifications('info', 'Началась загрузка направлений обучения!');
            this.openPr();
            $.ajax({
                url: '/libraryreport/workprogram/getSpeciality',
                type: 'POST',
                async: true,
                data: {
                    year: this.changed.year
                },
                success: (answer) => {
                    toastr.clear();
                    let result;
                    this.specialitys = [];

                    try {
                        result = JSON.parse(answer);
                    } catch (e) {
                        this.notifications(
                            "error",
                            "При получении данных произошла ошибка!"
                        );
                        console.log(e + "\n\n" + answer);
                        return;
                    }


                    let spec = [];
                    result.forEach(function (item) {
                        spec.push({ FSPECIALITYCODE: item["FSPECIALITYCODE"], SPECIALITY: item["SPECIALITY"] });
                    });

                    this.specialitys = spec;

                    if (Object.keys(this.specialitys).length > 0) {
                        this.notifications("success", "Направления обучения загружены!");
                    } else {
                        this.notifications("error", "Не удалось загрузить направления на выбранный год!");
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке направлений обучения!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },
        //Загрузка формы обучения
        changeSpec() {
            this.forma = null;
            this.speccode = this.changed.speccode;
            this.disciplines = [];
            this.changed.discode = null;
            this.forms = [];
            this.changed.forma = null;
            this.listReports = [];
            this.report = [];
            this.listEmpty = [];
            this.notifications('info', 'Началась загрузка формы обучения!');
            this.openPr();
            this.speciality = this.specialitys[this.changed.speccode]["SPECIALITY"];
            this.speccode = this.specialitys[this.changed.speccode]["FSPECIALITYCODE"];
            $.ajax({
                url: '/libraryreport/workprogram/getForm',
                type: 'POST',
                async: true,
                data: {
                    year: this.changed.year,
                    speccode: this.speccode
                },
                success: (answer) => {
                    toastr.clear();
                    let result;
                    this.forms = [];

                    try {
                        result = JSON.parse(answer);
                    } catch (e) {
                        this.notifications(
                            "error",
                            "При получении данных произошла ошибка!"
                        );
                        console.log(e + "\n\n" + answer);
                        return;
                    }

                    this.notifications("success", "Направления обучения загружены!");

                    let form = [];

                    result.forEach(function (item) {
                        form.push({ FORMA: item["FORMA"] });
                    });

                    this.forms = form;
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке формы обучения!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },
        //Загрузка дисциплин
        changeForm() {
            this.forma = this.changed.forma;
            this.disciplines = [];
            this.listReports = [];
            this.report = [];
            this.listEmpty = [];
            this.notifications('info', 'Началась загрузка дисциплин!');
            this.openPr();
            $.ajax({
                url: '/libraryreport/workprogram/getDiscipline',
                type: 'POST',
                async: true,
                data: {
                    year: this.changed.year,
                    speccode: this.speccode,
                    forma: this.changed.forma
                },
                success: (answer) => {
                    toastr.clear();
                    let result;

                    try {
                        result = JSON.parse(answer);
                    } catch (e) {
                        this.notifications(
                            "error",
                            "При получении данных произошла ошибка!"
                        );
                        console.log(e + "\n\n" + answer);
                        return;
                    }

                    this.notifications("success", "Дисциплины загружены!");

                    let disc = [];
                    let i = 0;
                    result.forEach(function (item) {
                        disc.push({ INDEX: i, DISCODE: item["DISCODE"], DISCIPLINE: item["DISCIPLINE"] });
                        i++;
                    });

                    this.disciplines = disc;
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке дисциплин!');
                },
                complete:() => {
                    if (this.changed.forma == "Очная") this.studCoef = 0.25;
                    else this.studCoef = 0.5;
                    this.closePr();
                }
            })
        },
        //Загрузка количества студентов
        changeDisc() {
            this.notifications('info', 'Определение количества студентов!');
            this.openPr();
            this.discipline = this.disciplines[this.changed.discode]["DISCIPLINE"];
            this.discode = this.disciplines[this.changed.discode]["DISCODE"];
            $.ajax({
                url: '/libraryreport/workprogram/getStudCount',
                type: 'POST',
                async: true,
                data: {
                    year: this.changed.year,
                    speccode: this.speccode,
                    forma: this.changed.forma
                },
                success: (answer) => {
                    toastr.clear();
                    let result;

                    try {
                        result = JSON.parse(answer);
                        this.notifications("success", "Количество студентов загружено!");
                        this.studCount = result[0]["STUDCOUNT"];
                    } catch (e) {
                        this.notifications(
                            "error",
                            "При получении данных произошла ошибка!"
                        );
                        this.studCount = 0;
                        console.log(e + "\n\n" + answer);
                        return;
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке количества студентов!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        //Начало составления БС и получение FNREC
        startCreate() {
            this.status = 1;
            //Определяем соответствующую запись RPD
            this.notifications('info', 'Определение соответствующей записи рабочих программ дисциплин!');
            this.openPr();
            $.ajax({
                url: '/libraryreport/workprogram/getFNRec',
                type: 'POST',
                async: true,
                data: {
                    year: this.changed.year,
                    speccode: this.speccode,
                    forma: this.changed.forma,
                    discode: this.discode
                },
                success: (answer) => {
                    toastr.clear();
                    let result;
                    try {
                        result = JSON.parse(answer);
                        this.notifications("success", "Рабочая программа дисциплин найдена!");
                        this.fnrec = result[0]["UCD_FNREC"];
                    } catch (e) {
                        this.notifications(
                            "error",
                            "При получении данных произошла ошибка!"
                        );
                        this.fnrec = "XXX";
                        console.log(e + "\n\n" + answer);
                        return;
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при поиске рабочей программы!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        createNewReport(fnrec, discode, discipline) {
            this.status = 1;
            this.page = 1;
            //Определяем соответствующую запись RPD
            this.notifications('info', 'Определение соответствующей записи рабочих программ дисциплин!');
            this.openPr();
            this.discode = discode;
            this.fnrec = fnrec;
            this.discipline = discipline;
            $.ajax({
                url: '/libraryreport/workprogram/getStudCount',
                type: 'POST',
                async: true,
                data: {
                    year: this.year,
                    speccode: this.speccode,
                    forma: this.forma
                },
                success: (answer) => {
                    toastr.clear();
                    let result;

                    try {
                        result = JSON.parse(answer);
                        this.notifications("success", "Количество студентов загружено!");
                        this.studCount = result[0]["STUDCOUNT"];
                    } catch (e) {
                        this.notifications(
                            "error",
                            "При получении данных произошла ошибка!"
                        );
                        this.studCount = 0;
                        console.log(e + "\n\n" + answer);
                        return;
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке количества студентов!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        /* Методы секции поиска литературы 
        *
        *
        */
        //Выполнение поиска литературы
        startSearch: function () {
            //this.openPr();
            $.ajax({
                url: '/libraryreport/compiler/search',
                type: 'POST',
                async: true,
                data: {
                    author: this.search.author,
                    title: this.search.title,
                    keyWords: this.search.keyWords,
                    stopWords: this.search.stopWords,
                    studCount: this.studCount,
                    studCoef: this.studCoef,
                    filters: this.search.filters
                },
                success: (answer) => {
                    toastr.clear();
                    this.search.result = JSON.parse(answer);
                    if (this.search.result !== 0) {
                        if (Object.keys(this.search.result[0]['Author']).length > 0) {
                            this.notifications('success', 'Литература успешно загружена!');
                        } else {
                            this.notifications('error', 'Литература по запросу не найдена');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске литературы');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при выполнении поиска');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },
        //Проверка введенных параметров в форму поиска литературы
        checkSearch: function () {
            if ((this.search.author.length + this.search.title.length + this.search.keyWords.length) < 6) {
                this.notifications('error', 'Недостаточно данных для поиска литературы');
            } else {
                this.notifications('warning', 'Процесс может занять некоторое время. <p><b>Запаситель терпением</b></p>', 120000, 0);
                //Очистка таблицы результатов
                this.search.result = null;
                this.startSearch();
            }
        },
        //Добавление литературы в составляемую справку
        addBook(book, type) {
            //  Author              -   автор издания
            //  Title               -   заглавие издания
            //  Link                -   ссылка на издание
            //  ViewOfPublication   -   вид издания
            //  YearOfPublication   -   год издания
            //  SmallDescription    -   краткое описание
            //  NumberOfCopies      -   количество экземпляров в библиотеке

            if (this.search.result[book]['ViewOfPublication'] == "[Текст]") {
                if (Object.keys(this.tBooks).length > 0) {
                    for(let i = 0; i < Object.keys(this.tBooks).length; i++) {
                        if (this.search.result[book]['SmallDescription'] == this.tBooks[i]["description"]) {
                            this.notifications('error', 'Данная литература уже была добавленна в библиографическую справку');
                            return;
                        } 
                    }
                    this.tBooks.push({
                        author: this.search.result[book]['Author'],
                        title: this.search.result[book]['Title'],
                        year: this.search.result[book]['YearOfPublication'],
                        description: this.search.result[book]['SmallDescription'],
                        countInLib: this.search.result[book]['NumberOfCopies'],
                        count: (this.changed.forma == "Очная") ? (Math.round(this.studCount / 4)) : (Math.round(this.studCount / 2)),
                        type: (type == 1) ? 1 : null
                    });
                    this.countAllBook++;
                    this.countTBook++;
                    (type == 0) ? this.countBBook++ : this.countABook++;
                } else {
                    this.tBooks.push({
                        author: this.search.result[book]['Author'],
                        title: this.search.result[book]['Title'],
                        year: this.search.result[book]['YearOfPublication'],
                        description: this.search.result[book]['SmallDescription'],
                        countInLib: this.search.result[book]['NumberOfCopies'],
                        count: (this.changed.forma == "Очная") ? (Math.round(this.studCount / 4)) : (Math.round(this.studCount / 2)),
                        type: (type == 1) ? 1 : null
                    });
                    this.countAllBook++;
                    this.countTBook++;
                    (type == 0) ? this.countBBook++ : this.countABook++;
                }
                
            } else {
                if (Object.keys(this.eBooks).length > 0) {
                    for(let i = 0; i < Object.keys(this.eBooks).length; i++) {
                        if (this.search.result[book]['SmallDescription'] == this.eBooks[i]["description"]) {
                            this.notifications('error', 'Данная литература уже была добавленна в библиографическую справку');
                            return;
                        } 
                    }
                    this.eBooks.push({
                        author: this.search.result[book]['Author'],
                        title: this.search.result[book]['Title'],
                        link: this.search.result[book]['Link'],
                        year: this.search.result[book]['YearOfPublication'],
                        description: this.search.result[book]['SmallDescription'],
                        countInLib: this.search.result[book]['NumberOfCopies'],
                        count: 1,
                        type: (type == 1) ? 1 : null
                    });
                    this.countAllBook++;
                    this.countEBook++;
                    (type == 0) ? this.countBBook++ : this.countABook++;
                } else {
                    this.eBooks.push({
                        author: this.search.result[book]['Author'],
                        title: this.search.result[book]['Title'],
                        link: this.search.result[book]['Link'],
                        year: this.search.result[book]['YearOfPublication'],
                        description: this.search.result[book]['SmallDescription'],
                        countInLib: this.search.result[book]['NumberOfCopies'],
                        count: 1,
                        type: (type == 1) ? 1 : null
                    });
                    this.countAllBook++;
                    this.countEBook++;
                    (type == 0) ? this.countBBook++ : this.countABook++;
                }
            }
            this.notifications('success', 'Литература успешно добавленна');
            //Удаляем элемент из массива
            this.search.result.splice(book, 1);
            //Отмечаем полноту составленной справки
            ((this.countBBook > 0) && (this.countABook > 0)) ? this.full = 1 : this.full = 0;
        },

        //Удаление литературы из составляемой БС
        delBook(book, view) {
            //  book    ->  индекс литературы в массиве
            //  view    ->  вид литературы
            if (view == 0) {
                this.countAllBook--;
                this.countTBook--;
                type = this.tBooks[book]["type"];
                (type != null) ? this.countABook-- : this.countBBook--;
                this.tBooks.splice(book, 1);
            } else {
                this.countAllBook--;
                this.countEBook--;
                type = this.eBooks[book]["type"];
                (type != null) ? this.countABook-- : this.countBBook--;
                this.eBooks.splice(book, 1);
            }
            if ((this.countBBook == 0) || (this.countABook == 0)) this.full = 0;
        },

        getMySuccess() {
            this.notifications('info', 'Началось загрузка принятых библиографических справок');
            this.openPr();
            this.listReports = [];
            this.report = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getSuccessByCompiler',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.listReports = JSON.parse(answer);
                    if (this.listReports !== 0) {
                        if (Object.keys(this.listReports).length > 0) {
                            this.notifications('success', 'Библиографические справки успешно загружены!');
                        } else {
                            this.notifications('error', 'Библиографические справки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске справок');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке библиографических справок!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        getMyDanger() {
            this.notifications('info', 'Началось загрузка принятых библиографических справок');
            this.openPr();
            this.listReports = [];
            this.report = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getDangerByCompiler',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.listReports = JSON.parse(answer);
                    if (this.listReports !== 0) {
                        if (Object.keys(this.listReports).length > 0) {
                            this.notifications('success', 'Библиографические справки успешно загружены!');
                        } else {
                            this.notifications('error', 'Библиографические справки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске справок');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке библиографических справок!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        getMyNew() {
            this.notifications('info', 'Началось загрузка принятых библиографических справок');
            this.openPr();
            this.listReports = [];
            this.report = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getNewByCompiler',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.listReports = JSON.parse(answer);
                    if (this.listReports !== 0) {
                        if (Object.keys(this.listReports).length > 0) {
                            this.notifications('success', 'Библиографические справки успешно загружены!');
                        } else {
                            this.notifications('error', 'Библиографические справки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске справок');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке библиографических справок!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        getMyAll() {
            this.notifications('info', 'Началось загрузка принятых библиографических справок');
            this.openPr();
            this.listReports = [];
            this.report = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getAllByCompiler',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.listReports = JSON.parse(answer);
                    if (this.listReports !== 0) {
                        if (Object.keys(this.listReports).length > 0) {
                            this.notifications('success', 'Библиографические справки успешно загружены!');
                        } else {
                            this.notifications('error', 'Библиографические справки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске справок');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке библиографических справок!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        getEmpty() {
            this.notifications('info', 'Началась загрузка');
            this.openPr();
            this.listReports = [];
            this.report = [];
            this.listEmpty = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getEmpty',
                type: 'POST',
                async: true,
                data: {
                    year: this.year,
                    speccode: this.speccode, 
                    forma: this.forma
                },
                success: (answer) => {
                    toastr.clear();
                    this.listEmpty = JSON.parse(answer);
                    if (this.listEmpty !== 0) {
                        if (Object.keys(this.listEmpty).length > 0) {
                            this.notifications('success', 'Списки успешно загружены!');
                        } else {
                            this.notifications('error', 'Списки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске списка');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке списков!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        getReport(ucd_fnrec) {
            this.notifications('info', 'Началось загрузка библиографической справки');
            this.openPr();
            this.listReports = [];
            this.report = [];
            this.disciplinesStarted = [];
            this.fnrec = ucd_fnrec;
            this.specialitysStarted = [], //Начатые специальности
            this.page = 0;
            $.ajax({
                url: '/libraryreport/libraryreport/getReport',
                type: 'POST',
                async: true,
                data: {
                    ucd_fnrec: ucd_fnrec
                },
                success: (answer) => {
                    toastr.clear();
                    this.report = JSON.parse(answer);
                    if (this.report != 0) {
                        if (Object.keys(this.report).length > 0) {
                            this.notifications('success', 'Библиографическая справка успешно загружена!');
                            this.section = 1;
                            this.report[0]["COUNTLITERATURE"]["countAllBook"] = Number.parseInt(this.report[0]["COUNTLITERATURE"]["countAllBook"]);
                            this.report[0]["COUNTLITERATURE"]["countAllBook"] = this.report[0]["COUNTLITERATURE"]["countAllBook"] + 1;
                            this.report[0]["COUNTLITERATURE"]["countTBook"] = Number.parseInt(this.report[0]["COUNTLITERATURE"]["countTBook"]);
                            this.report[0]["COUNTLITERATURE"]["countTBook"] = this.report[0]["COUNTLITERATURE"]["countTBook"] + 1;
                        } else {
                            this.notifications('error', 'Библиографическая справка не найдена');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске справки');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке библиографической справки!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        getReports(year, speccode, forma) {
            this.notifications('info', 'Началось загрузка начатых дисциплин по направлению');
            this.openPr();
            this.fnrec = null;
            this.listReports = [],        //Список библиографических спраок
            this.listEmpty = [],          //Список несоставленных библиографических справок
            this.disciplinesStarted = [];
            this.specialitysStarted = [];
            this.report = [];
            this.speccode = speccode;
            $.ajax({
                url: '/libraryreport/libraryreport/getReports',
                type: 'POST',
                async: true,
                data: {
                    year: year,
                    speccode: speccode,
                    forma: forma
                },
                success: (data) => {
                    toastr.clear();
                    this.disciplinesStarted = JSON.parse(data);
                    if (this.disciplinesStarted !== 0) {
                        if (Object.keys(this.disciplinesStarted).length > 0) {
                            this.notifications('success', 'Начатые библиографические справки успешно загружены!');
                        } else {
                            this.notifications('error', 'Начатые библиографическкие справки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске начатых справок');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке начатых библиографических справок!');
                },
                complete: () => {
                    this.closePr();
                }
            })
        },

        editReport(ucd_fnrec) {
            this.notifications('info', 'Началось загрузка библиографической справки');
            this.openPr();
            this.listReports = [];
            this.report = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getReport',
                type: 'POST',
                async: true,
                data: {
                    ucd_fnrec: ucd_fnrec
                },
                success: (answer) => {
                    toastr.clear();
                    let result = JSON.parse(answer);
                    if (result != 0) {
                        if (Object.keys(result).length > 0) {
                            this.notifications('success', 'Библиографическая справка успешно загружена!');
                            this.edit = 1;
                            this.page = 1;
                            this.year = result[0]["YEARED"];                //Года набора
                            this.speciality = result[0]["SPECIALITY"];      //Направления обучения
                            this.speccode = result[0]["SPECIALITYCODE"];
                            this.forma = result[0]["FORMA"];             //Формы обучения
                            this.discipline = result[0]["DISCIPLINE"];      //Дисциплины
                            this.discode = result[0]["DISCODE"];
                            this.fgos = result[0]["FGOS"];
                            this.fnrec = ucd_fnrec;
                            this.studCount = result[0]["COUNTSTUDENTS"];
                            (this.forma == "Очная") ? this.studCoef = 0.25 : this.studCoef = 0.5;
                            this.status = 2;
                            this.full = 1;
                            (result[0]["TLITERATURE"] == null) ? this.tBooks = [] : this.tBooks=result[0]["TLITERATURE"];
                            (result[0]["ELITERATURE"] == null) ? this.eBooks = [] : this.eBooks=result[0]["ELITERATURE"];
                            this.countAllBook = Number.parseInt(result[0]["COUNTLITERATURE"]["countAllBook"]);
                            this.countTBook = Number.parseInt(result[0]["COUNTLITERATURE"]["countTBook"]);
                            this.countEBook = Number.parseInt(result[0]["COUNTLITERATURE"]["countEBook"]);
                            this.countBBook = Number.parseInt(result[0]["COUNTLITERATURE"]["countBBook"]);
                            this.countABook = Number.parseInt(result[0]["COUNTLITERATURE"]["countABook"]);
                        } else {
                            this.notifications('error', 'Библиографическая справка не найдена');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске справки');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке библиографической справки!');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        //Для совместимости с Firefox симулируем нажатие кнопки мыши
        //Ссылка на документацию: https://developer.mozilla.org/ru/docs/Web/API/MouseEvent
        simulateClick(link) {
            var evt = new MouseEvent("click");
            setTimeout(() => {
                link.dispatchEvent(evt);
            }, 500);
        },

        //Запись справки в БД
        saveInDB() {
            this.notifications('info', 'Началось сохранение составленной справки!');
            this.openPr();
            let year = this.changed.year;
            let speccode = this.speccode;
            let speciality = this.speciality;
            let discode = this.discode;
            let discipline = this.discipline;
            let forma = this.changed.forma;
            let fgos = 'fgos3';
            let fnrec = this.fnrec;
            let studCount = this.studCount;
            let studCoef = this.studCoef;
            let countAllBook = this.countAllBook;
            let countTBook = this.countTBook;
            let countEBook = this.countEBook;
            let countABook = this.countABook;
            let countBBook = this.countBBook;
            let tBooks = this.tBooks;
            let eBooks = this.eBooks;
            let edit = this.edit;
            $.ajax({
                url: '/libraryreport/libraryreport/savenew',
                type: 'POST',
                async: true,
                data: {
                    year: year,
                    speccode: speccode,
                    speciality: speciality,
                    discode: discode,
                    discipline: discipline,
                    forma: forma,
                    fgos: fgos,
                    fnrec: fnrec,
                    studCount: studCount,
                    studCoef: studCoef,
                    countAllBook: countAllBook,
                    countTBook: countTBook,
                    countEBook: countEBook,
                    countABook: countABook,
                    countBBook: countBBook,
                    tBooks: tBooks,
                    eBooks: eBooks,
                    edit: edit
                },
                success: (answer) => {
                    toastr.clear();
                    this.notifications('success', 'Библиографическая справка успешно сохранена');
                    this.cleanAll();
                    this.changed.year = this.year;
                    this.changed.discode = this.discode;
                    this.changed.forma = this.forma;
                    //this.getMyAll();
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при сохранении справки');
                },
                complete:() => {
                    this.closePr();
                }
            })
        },

        //Очистка составляемой справки от литературы
        cleanBooks() {
            this.countAllBook = 0;
            this.countTBook = 0;
            this.countEBook = 0;
            this.countABook = 0;
            this.countBBook = 0;
            this.eBooks = [];
            this.tBooks = [];
            this.full = 0;
            this.notifications('success', 'Составляемая справка успешно очищена');
        },

        cleanAll() {
            this.full = 0;
            this.edit = 0;
            this.result = [];
            this.fgoses = [],         //ФГОСы
            this.fnrec = null,        //Соответствующая запись в RPD
            this.notifications('success', 'Составляемая справка успешно очищена');
            this.status = null;
            this.page = 1;
            this.getEmpty();
        },

        /*
        *
        *   /////////////////////////////////////////////////
        *   /////////////////////////////////////////////////
        *   /////////////////////////////////////////////////
        *   ///////////////    Общие методы    //////////////
        *   /////////////////////////////////////////////////
        *   /////////////////////////////////////////////////
        *   /////////////////////////////////////////////////
        *
        */


        //Уведомления
        notifications(type, message, time = 3000, timeDur = 300) {
            toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: false,
                progressBar: false,
                positionClass: 'toast-top-right',
                preventDuplicates: false,
                onclick: null,
                showDuration: timeDur,
                hideDuration: timeDur,
                timeOut: time,
                extendedTimeOut: '300',
                showEasing: 'swing',
                hideEasing: 'linear',
                showMethod: 'fadeIn',
                hideMethod: 'fadeOut',
            };
            switch (type) {
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                default:
                    break;
            }
        },
        // Открыть прелодер
        openPr: function () {
            $('.overlay').show();
        },
        // Закрыть прелоадер
        closePr: function () {
            $('.overlay').fadeOut(250);
        },
        //
        created: function () {
            this.getStarted();
        },
    },
    created: function () {
        
        //Берем текущий год в js
        var currentDate = new Date();
        var year;

        //Если ранее июня, то берем еще за предыдущий год (календарный)
        currentDate.getMonth() < 5
            ? (year = currentDate.getFullYear() - 1)
            : (year = currentDate.getFullYear());

        //Добавляем 1 год назад и 4 года вперед
        for ($i = year - 1; $i <= year; $i++) {
            this.years.push($i);
        };

        
        this.page = 0;
        this.created();
    }
});