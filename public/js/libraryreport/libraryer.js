//Test Vue.JS

const app = new Vue({
    el: '#app',
    data: {
        reports: [],
        report: [],
        specialitysStarted: [],
        specialitysNoStarted: [],
        disciplinesStarted: [],
        disciplinesNoStarted: [],
        listEmptyPage: 'success',
        danger: null,
        ucd_fnrec: null,
        started: 1,
        select: 0,
        section: 0,
        alertMessage: "",
        dangerMessage: ""
    },
    methods: {

        //Загрузка всех новых справок
        getNew() {
            this.notifications('info', 'Началось загрузка новых библиографических справок');
            this.openPr();
            this.reports = [];
            this.ucd_fnrec = null;
            this.disciplinesStarted = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getNew',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.reports = JSON.parse(answer);
                    if (this.reports !== 0) {
                        if (Object.keys(this.reports).length > 0) {
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
                always: function () {
                    this.closePr();
                }.bind(this)
            })
            this.closePr();
        },

        getSuccess() {
            this.notifications('info', 'Началось загрузка принятых библиографических справок');
            this.openPr();
            this.reports = [];
            this.ucd_fnrec = null;
            this.disciplinesStarted = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getSuccess',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.reports = JSON.parse(answer);
                    if (this.reports !== 0) {
                        if (Object.keys(this.reports).length > 0) {
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
                always: function () {
                    this.closePr();
                }.bind(this)
            })
            this.closePr();
        },

        getDanger() {
            this.notifications('info', 'Началось загрузка отклоненных библиографических справок');
            this.openPr();
            this.reports = [];
            this.ucd_fnrec = null;
            this.disciplinesStarted = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getDanger',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.reports = JSON.parse(answer);
                    if (this.reports !== 0) {
                        if (Object.keys(this.reports).length > 0) {
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
                always: function () {
                    this.closePr();
                }.bind(this)
            })
            this.closePr();
        },

        getAll() {
            this.notifications('info', 'Началось загрузка всех библиографических справок');
            this.openPr();
            this.reports = [];
            this.ucd_fnrec = null;
            this.disciplinesStarted = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getAll',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.reports = JSON.parse(answer);
                    if (this.reports !== 0) {
                        if (Object.keys(this.reports).length > 0) {
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
                always: function () {
                    this.closePr();
                }.bind(this)
            })
            this.closePr();
        },

        getReport(ucd_fnrec) {
            this.notifications('info', 'Началось загрузка библиографической справки');
            this.openPr();
            this.report = [];
            this.disciplinesStarted = [];
            this.ucd_fnrec = ucd_fnrec;
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
                always: function () {
                    this.closePr();
                }.bind(this)
            })
            this.closePr();
        },

        successReport(ucd_fnrec) {
            this.notifications('info', 'Началось обновление библиографической справки');
            this.openPr();
            this.report = [];
            $.ajax({
                url: '/libraryreport/libraryreport/successReport',
                type: 'POST',
                async: true,
                data: {
                    ucd_fnrec: ucd_fnrec
                },
                success: (answer) => {
                    toastr.clear();
                    this.report = JSON.parse(answer);
                    if (this.report != 0) {
                        if (this.report != 0) {
                            this.notifications('success', 'Библиографическая справка успешно принята!');
                        } else {
                            this.notifications('error', 'Библиографическая справка не принята');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при принятии справки');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при принятии библиографической справки!');
                },
                complete: () => {
                    this.closePr();
                    this.ucd_fnrec = null;
                    this.alertMessage = "";
                    this.getReport(ucd_fnrec);
                },
            })
        },

        dangerReport(ucd_fnrec) {
            if (this.danger == null) {
                this.danger = 1;
                return;
            } else if (this.dangerMessage.length < 50) {
                this.alertMessage = "Длина комментария менее 50 символов";
                return;
            }
            this.notifications('info', 'Началось обновление библиографической справки');
            this.openPr();
            this.report = [];
            let message = this.dangerMessage;
            $.ajax({
                url: '/libraryreport/libraryreport/dangerReport',
                type: 'POST',
                async: true,
                data: {
                    message: message,
                    ucd_fnrec: ucd_fnrec
                },
                success: (answer) => {
                    toastr.clear();
                    this.report = JSON.parse(answer);
                    if (this.report != 0) {
                        if (this.report != 0) {
                            this.notifications('success', 'Библиографическая справка успешно отклонена!');
                        } else {
                            this.notifications('error', 'Библиографическая справка не отклонена');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при отклонении справки');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при отклонении библиографической справки!');
                },
                complete: () => {
                    this.closePr();
                    this.danger = null;
                    this.alertMessage = "";
                    this.getReport(ucd_fnrec);
                },
            })
        },

        printReport(ucd_fnrec) {
            this.notifications('info', 'Началось формирование библиографической справки');
            this.openPr();
            this.report = [];
            $.ajax({
                type: 'POST',
                url: '/libraryreport/libraryreport/printReport',
                data: {
                    // из docData берётся только nrec заявки
                    ucd_fnrec: ucd_fnrec
                },
                success: (data) => {
                    try {
                        //Сохранение
                        var link = document.createElement('a');
                        var btn = document.createElement('button');
                        link.setAttribute('href', JSON.parse(data).url);
                        btn.addEventListener('click', this.simulateClick(link));
                        this.notifications('info', 'Документ успешно сохранен!');
                    } catch (e) {
                        this.closePr();
                        this.notifications('alert', 'Ошибка сохранения!');
                    }
                },
                error: (error) => { },
                complete: () => {
                    this.closePr();
                    this.getReport(ucd_fnrec);
                },
            });
        },

        printReports(year, speccode, forma) {
            this.notifications('info', 'Началось формирование библиографической справки');
            this.openPr();
            this.report = [];
            $.ajax({
                type: 'POST',
                url: '/libraryreport/libraryreport/printReports',
                data: {
                    year: year,
                    speccode: speccode,
                    forma: forma
                },
                success: (data) => {
                    try {
                        //Сохранение
                        var link = document.createElement('a');
                        var btn = document.createElement('button');
                        link.setAttribute('href', JSON.parse(data).url);
                        btn.addEventListener('click', this.simulateClick(link));
                        this.notifications('info', 'Документ успешно сохранен!');
                    } catch (e) {
                        this.closePr();
                        this.notifications('alert', 'Ошибка сохранения!');
                    }
                },
                error: (error) => { },
                complete: () => {
                    this.closePr();
                    this.getReport(ucd_fnrec);
                },
            });
        },

        getStarted() {
            this.notifications('info', 'Началось загрузка начатых библиографических справок. Это может занять некоторое время. <b>Запаситесь терпением</b>', 100000);
            this.openPr();
            this.specialitys = [];
            this.disciplines = [];
            this.ucd_fnrec = null;
            this.started = 1;
            this.page = 1;
            this.disciplinesStarted = [];
            this.specialitysNoStarted = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getStarted',
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
                            this.notifications('error', 'Начатые библиографические справки не найдены');
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

        
        getStartedNew() {
            this.notifications('info', 'Началось загрузка непроверенных библиографических справок. Это может занять некоторое время. <b>Запаситесь терпением</b>', 100000);
            this.openPr();
            this.specialitys = [];
            this.disciplines = [];
            this.ucd_fnrec = null;
            this.started = 1;
            this.page = 1;
            this.disciplinesStarted = [];
            this.specialitysNoStarted = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getStartedNew',
                type: 'POST',
                async: true,
                data: {
                },
                success: (answer) => {
                    toastr.clear();
                    this.specialitysStarted = JSON.parse(answer);
                    if (this.specialitysStarted !== 0) {
                        if (Object.keys(this.specialitysStarted).length > 0) {
                            this.notifications('success', 'Непроверенные библиографические справки успешно загружены!');
                        } else {
                            this.notifications('error', 'Непроверенные библиографические справки не найдены');
                        }
                    } else {
                        this.notifications('error', 'Произошла ошибка при поиске непроверенных справок');
                    }
                },
                error: function () {
                    toastr.clear();
                    this.notifications('error', 'Произошла ошибка при загрузке непроверенных библиографических справок!');
                },
                complete: () => {
                    this.closePr();
                }
            });
        },

        getNoStarted() {
            this.notifications('info', 'Началось загрузка не начатых дисциплин');
            this.openPr();
            this.specialitys = [];
            this.disciplines = [];
            this.ucd_fnrec = null;
            this.started = 1;
            this.disciplinesStarted = [];
            this.specialitysStarted = [];
            this.specialitysNoStarted = [];
            $.ajax({
                url: '/libraryreport/libraryreport/getNoStarted',
                type: 'POST',
                async: true,
                data: {
                },
                success: (data) => {
                    toastr.clear();
                    this.specialitysNoStarted = JSON.parse(data);
                    if (this.specialitysNoStarted !== 0) {
                        if (Object.keys(this.specialitysNoStarted).length > 0) {
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

        getReports(year, speccode, forma) {
            this.notifications('info', 'Началось загрузка начатых дисциплин по направлению');
            this.openPr();
            this.reports = [],
            this.report = [],
            this.specialitys = [];
            this.disciplines = [];
            this.ucd_fnrec = null;
            this.started = 1;
            this.select = 1;
            this.disciplinesStarted = [];
            this.specialitysStarted = [];
            this.specialitysNoStarted = [];
            this.speccode = speccode;
            this.forma = forma;
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

        //Для совместимости с Firefox симулируем нажатие кнопки мыши
        //Ссылка на документацию: https://developer.mozilla.org/ru/docs/Web/API/MouseEvent
        simulateClick(link) {
            var evt = new MouseEvent("click");
            setTimeout(() => {
                link.dispatchEvent(evt);
            }, 500);
        },

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
    },
    created: function () {
        this.getStartedNew();
    }
});