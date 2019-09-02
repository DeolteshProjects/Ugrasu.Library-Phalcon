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
  <div class="small-12 medium-12 large-12 columns">
    <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
    <table cellspacing="0">
      <thead>
        <tr>
          <td>Учебный год</td>
          <td>Направление</td>
          <td>Форма обучения</td>
          <td colspan="2">Действия</td>
        </tr>
      </thead>
      <tbody>
        <tr v-for='(spec, index) in specialitysStarted[0]'>
          <td>{{'{{ spec.FYEARED }}'}}</td>
          <td>{{'{{ spec["FSPECIALITYCODE"] }}'}} - {{'{{ spec["SPECIALITY"] }}'}}</td>
          <td>{{'{{ spec["FORMA"] }}'}}</td>
          <td colspan="2">
            <template v-if="((spec['F2']) > 0)">
              <button class="btn btn-lg btn-info" @click="getReports(spec.FYEARED, spec['FSPECIALITYCODE'], spec['FORMA'])">
                Открыть
              </button>
            </template>
            <template v-if="(spec['F1'] == spec['F2'])">
              <button class="btn btn-lg btn-warning" @click="printReports(spec.FYEARED, spec['FSPECIALITYCODE'], spec['FORMA'])">
                Скачать
              </button>
            </template>
            <template v-if="(spec['F2']) == 0">
              <button class="btn btn-lg btn-danger col-md-12">На начата</button>
            </template>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>