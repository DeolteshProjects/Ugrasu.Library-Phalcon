<!-- Форма вывода библиографической справки -->
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
              подготовки "{{'{{ report[0]["SPECIALITYCODE"] }}'}} - {{'{{ report[0]["SPECIALITY"] }}'}}"
              , {{'{{ report[0]["YEARED"] }}'}} год набора. {{'{{ report[0]["FORMA"] }}'}} форма обучения.
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
      <tr>
        <td class="text-center align-middle" :rowspan="report[0]['COUNTLITERATURE']['countAllBook']"> 1
        </td>
        <td class="text-center align-middle" :rowspan="report[0]['COUNTLITERATURE']['countAllBook']">
          {{'{{ report[0]["DISCIPLINE"] }}'}}</td>
        <template v-if:="report[0]['COUNTLITERATURE']['countTBook'] > 0">
          <td class="text-center align-middle" :rowspan="report[0]['COUNTLITERATURE']['countTBook']">Печатные
            учебные издания
          </td>
          <td>
            1. {{'{{ report[0]["TLITERATURE"][0]["author"] }}'}}. {{'{{ report[0]["TLITERATURE"][0]["description"] }}'}}
            <template v-if='report[0]["TLITERATURE"][0]["type"] == 1'>
              <b class='text-primary-color'>(Дополнительная)</b>
            </template>
          </td>
          <td class="text-center align-middle">{{'{{ report[0]["TLITERATURE"][0]["count"] }}'}}
            из {{'{{ report[0]["TLITERATURE"][0]["countInLib"] }}'}}</td>
          <td class="text-center align-middle">
            <b v-if="report[0]['FORMA'] == 'Очная'"> 0,25 </b>
            <b v-else> 0,5 </b>
          </td>
        </template>
      </tr>
      <template v-if="report[0]['COUNTLITERATURE']['countTBook'] > 1">
        <tr v-for='(book, index) in report[0]["TLITERATURE"]'>
          <template v-if="index > 0">
            <td>{{'{{ index+1 }}'}}. {{'{{ book["author"] }}'}}. {{'{{ book["description"] }}'}}
              <template v-if='book["type"] != null'>
                <b class='text-primary-color'>(Дополнительная)</b>
              </template>
            </td>
            <td class="text-center align-middle">{{'{{ book["count"] }}'}}
              из {{'{{ book["countInLib"] }}'}}</td>
            <td class="text-center align-middle">
              <b v-if="report[0]['FORMA'] == 'Очная'"> 0,25 </b>
              <b v-else> 0,5 </b>
            </td>
          </template>
        </tr>
      </template>
      <tr v-if="report[0]['COUNTLITERATURE']['countEBook'] > 0">
        <td class="text-center align-middle" :rowspan="report[0]['COUNTLITERATURE']['countAllBook'] + 1"> 1
        </td>
        <td class="text-center align-middle" :rowspan="report[0]['COUNTLITERATURE']['countAllBook'] +1">
          {{'{{ changed.discode }}'}}</td>
        <template v-if:="report[0]['COUNTLITERATURE']['countEBook'] > 0">
          <td class="text-center align-middle" :rowspan="report[0]['COUNTLITERATURE']['countEBook'] + 1">Электронные
            учебные издания, имеющиеся в электронном каталоге
            электронно-библиотечной системы
          </td>
          <td>
            1. {{'{{ report[0]["ELITERATURE"][0]["author"] }}'}}. {{'{{ report[0]["ELITERATURE"][0]["description"] }}'}}
            <template v-if='report[0]["ELITERATURE"][0]["type"] = 1'>
              <b class='text-primary-color'>(Дополнительная)</b>
            </template>
          </td>
          <td class="text-center align-middle">{{'{{ report[0]["ELITERATURE"][0]["count"] }}'}}
            из {{'{{ report[0]["ELITERATURE"][0]["countInLib"] }}'}}</td>
          <td class="text-center align-middle">
            <b v-if="report[0]['FORMA'] == 'Очная'"> 0,25 </b>
            <b v-else> 0,5 </b>
          </td>
        </template>
      </tr>
      <template v-if="report[0]['COUNTLITERATURE']['countEBook']  > 1">
        <tr v-for="(book, index) in report[0]['ELITERATURE']">
          <template v-if="index > 0">
            <td>{{'{{ index+1 }}'}}. {{'{{ book["author"] }}'}}. {{'{{ book["description"] }}'}}
              <template v-if='book["type"] != null'>
                <b class='text-primary-color'>(Дополнительная)</b>
              </template>
            </td>
            <td class="text-center align-middle">{{'{{ book["count"] }}'}}
              из {{'{{ book["countInLib"] }}'}}</td>
            <td class="text-center align-middle">
              <b v-if="report[0]['FORMA'] == 'Очная'"> 0,25 </b>
              <b v-else> 0,5 </b>
            </td>
          </template>
        </tr>
      </template>
    </tbody>
  </table>
</div>