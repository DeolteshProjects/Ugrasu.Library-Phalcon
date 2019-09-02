<!-- Заголовок модуля -->
<div class="modules-header">
  <div class="header">
    <div class="header-title">
      <h4 class="title">Состатавленные библиографические справки</h4>
    </div>
    <div class="header-content">
      <!-- -->
    </div>
  </div>
</div>
<!-- Тело модуля -->
<div class="modules-content">

  <!-- Форма вывода результатов поиска -->
  <div class="block-search-result small-12 medium-12 large-12 columns">
    <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
    <table cellspacing="0">
      <thead>
        <tr>
          <th>№</th>
          <th>Учебный год</th>
          <th>Направление</th>
          <th>Дисциплина</th>
          <th>Составитель</th>
          <th>Состояние</th>
          <th>Составленна / Обновлена</th>
          <th colspan="2">Действия</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(rep, index) in listReports">
          <td>{{'{{ index+1 }}'}}</td>
          <td>{{'{{ rep["YEARED"] }}'}}</td>
          <td>{{'{{ rep["SPECIALITY"] }}'}}</td>
          <td>{{'{{ rep["DISCIPLINE"] }}'}}</td>
          <td>{{'{{ rep["COMPILER"] }}'}}</td>
          <td class="btn btn-small btn-info" v-if="rep['STATUS'] == 0">
            <button>Новая</button>
          </td>
          <td class="btn btn-small btn-danger" v-if="rep['STATUS'] == 2">
            <button>Отклонена библиотекой</button>
          </td>
          <td class="btn btn-small btn-secondary" v-if="rep['STATUS'] == 8">
            <button>Исправлена</button>
          </td>
          <td class="btn btn-small btn-success" v-if="rep['STATUS'] == 10">
            <button>Принята библиотекой</button>
          </td>
          <td>
            <p>{{'{{ rep["CREATEDATE"] }}'}} / {{'{{ rep["UPDATEDATE"] }}'}}</p>
          </td>
          <td>
            <button class="btn btn-lg btn-info" @click="getReport(rep['UCD_FNREC'])">Открыть</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>