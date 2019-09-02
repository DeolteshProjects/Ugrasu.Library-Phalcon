<!-- Заголовок модуля -->
<div class="modules-header">
  <div class="header">
    <div class="header-title">
      <h4 class="title">Состатавленные вами библиографические справки</h4>
    </div>
    <div class="header-content">
      <!-- -->
    </div>
  </div>
</div>
<!-- Тело модуля -->
<div class="modules-content">

  <!-- Форма вывода результатов поиска -->
  <div class="small-12 medium-12 large-12 columns">
    <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
    <table cellspacing="0">
      <thead>
        <tr>
          <td>Учебный год</td>
          <td>Направление</td>
          <td>Форма обучения</td>
          <td>Состояние</td>
          <td colspan="2">Действия</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for='(spec, index) in specialitysStarted'>
          <td>{{'{{ spec["FYEARED"] }}'}}</td>
          <td>{{'{{ spec["FSPECIALITYCODE"] }}'}} - {{'{{ spec["SPECIALITY"] }}'}}</td>
          <td>{{'{{ spec["FORMA"] }}'}}</td>
          <td>
            <b v-if="spec['F1'] < spec['F2']" class="text-warning-color">Не законченна</b>
            <b v-if="spec['F1'] == spec['F2']" class="text-success-color">Готова к утверждению</b>
          </td>
          <td colspan="2">
            <button class="btn btn-lg btn-info" @click="getReports(spec['FYEARED'], spec['FSPECIALITYCODE'], spec['FORMA'])">
              Открыть
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>