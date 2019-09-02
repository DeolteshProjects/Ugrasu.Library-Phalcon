<!-- Заголовок модуля -->
<div class="modules-header">
  <div class="header">
    <div class="header-title">
      <h4 class="title">Модуль поиска литературы в научной библиотеке ЮГУ</h4>
      <small>Модуль находится в стадии переноса, функционал временно ограничен</small>
    </div>
    <div class="header-content">
      <!-- -->
    </div>
  </div>
</div>
<!-- Тело модуля -->
<div class="modules-content">
  <!-- Форма поиска -->
  <!-- Форма вывода результатов поиска -->
  <div class="block-show-result small-12 medium-12 large-12 columns">
    <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
    <table id="result-table">
      <thead>
        <tr>
          <td colspan="8" width="100%" class="center">
            <h6><b>
                СПРАВКА об обеспеченности
                учебно-методической
                документацией программы направления
                подготовки "{{'{{ speccode }}'}} - {{'{{ speciality }}'}}"
                , {{'{{ changed.year }}'}} год набора. {{'{{ changed.forma }}'}} форма обучения. 
            </b></h6>
          </td>
        </tr>
        <tr>
          <td width="5%" class="center">
            <p>№</p>
            <p>П/П</p>
          </td>
          <td class="center">Наименование дисциплины</td>
          <td colspan="2" class="center">Наименование печатных и (или) электронных учебных
            изданий,
            методические издания, периодические издания по всем входящим
            в реализуемую образовательную программу учебным предметам,
            курсам, дисциплинам (модулям) в соответствии с рабочими программами
            дисциплин, модулей, практик
          </td>
          <td class="center">Количество экземпляров</td>
          <td class="center">Cтудентов учебной литературой (экземпляров на одного студента)</td>
        </tr>
      </thead>
      <tbody>
        <tr v-if='countTBook > 0'>
          <td class="text-center align-middle" :rowspan="countAllBook + 1"> 1
          </td>
          <td class="text-center align-middle" :rowspan="countAllBook +1">{{'{{ discipline }}'}}</td>
          <template v-if:="countTBook > 0">
            <td class="text-center align-middle" :rowspan="countTBook + 1">Печатные
              учебные издания
            </td>
            <td>
              1. {{'{{ tBooks[0]["description"] }}'}}
              <template v-if='tBooks[0]["type"] == 1'>
                <b class='text-primary-color'>(Дополнительная)</b>
              </template>
              <p>
                <button @click="delBook(0, 0)" class="btn btn-danger">Удалить из составляемой справки</button>
              </p>
            </td>
            <td class="text-center align-middle">{{'{{ tBooks[0]["count"] }}'}}
              из {{'{{ tBooks[0]["countInLib"] }}'}}</td>
            <td class="text-center align-middle">
              {{'{{ studCoef }}'}}
            </td>
          </template>
        </tr>
        <template v-if="countTBook > 1">
          <tr v-for="(book, index) in tBooks">
            <template v-if="index > 0">
              <td>{{'{{ index+1 }}'}}. {{'{{ book["description"] }}'}}
                <template v-if='book["type"] != null'>
                  <b class='text-primary-color'>(Дополнительная)</b>
                </template>
                <p>
                  <button @click="delBook(index, 0)" class="btn btn-danger">Удалить из составляемой справки</button>
                </p>
              </td>
              <td class="text-center align-middle">{{'{{ book["count"] }}'}}
                из {{'{{ book["countInLib"] }}'}}</td>
              <td class="text-center align-middle">
                {{'{{ studCoef }}'}}
              </td>
            </template>
          </tr>
        </template>
        <tr v-if='countEBook > 0'>
          <td class="text-center align-middle" :rowspan="countAllBook + 1"> 1
          </td>
          <td class="text-center align-middle" :rowspan="countAllBook +1">{{'{{ changed.discode }}'}}</td>
          <template v-if:="countTBook > 0">
            <td class="text-center align-middle" :rowspan="countEBook + 1">Электронные
              учебные издания, имеющиеся в электронном каталоге
              электронно-библиотечной системы
            </td>
            <td>
              1. {{'{{ eBooks[0]["description"] }}'}}
              <template v-if='eBooks[0]["type"] = 1'>
                <b class='text-primary-color'>(Дополнительная)</b>
              </template>
              <p>
                <button @click="delBook(0, 1)" class="btn btn-danger">Удалить из составляемой справки</button>
              </p>
            </td>
            <td class="text-center align-middle">{{'{{ eBooks[0]["count"] }}'}}
              из {{'{{ eBooks[0]["countInLib"] }}'}}</td>
            <td class="text-center align-middle">
              {{'{{ studCoef }}'}}
            </td>
          </template>
        </tr>
        <template v-if="countEBook > 1">
          <tr v-for="(book, index) in tBooks">
            <template v-if="index > 0">
              <td>{{'{{ index+1 }}'}}. {{'{{ book["description"] }}'}}
                <template v-if='book["type"] != null'>
                  <b class='text-primary-color'>(Дополнительная)</b>
                </template>
                <p>
                  <button @click="delBook(index, 1)" class="btn btn-danger">Удалить из составляемой справки</button>
                </p>
              </td>
              <td class="text-center align-middle">{{'{{ book["count"] }}'}}
                из {{'{{ book["countInLib"] }}'}}</td>
              <td class="text-center align-middle">
                {{'{{ studCoef }}'}}
              </td>
            </template>
          </tr>
        </template>
      </tbody>
    </table>
  </div>

  <!-- Панель сохранения справки-->
  <div>
    <button @click="saveInDB()" v-if="full == 1" class="btn btn-success">Сохранить</button>
    <button @click="status = 1" class="btn btn-warning">Добавить литературу</button>
    <template v-if="countAllBook > 0">
        <button @click="cleanBooks()" class="btn btn-danger">Очистить составляемую справку от литературы</button>
    </template>
  </div>

</div>