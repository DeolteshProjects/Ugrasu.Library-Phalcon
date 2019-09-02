<!-- Форма вывода результатов поиска -->
<div class="small-12 medium-12 large-12 columns">
        <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
        <table cellspacing="0">
          <thead>
            <tr>
              <td>№</td>
              <td>Дисциплина</td>
              <td>Составитель</td>
              <td>Состояние</td>
              <td>Составленна / Обновлена</td>
              <td colspan="2">Действия</td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(disc, index) in disciplinesStarted[0]">
              <td>{{'{{ index+1 }}'}}</td>
              <td>{{'{{ disc["DISCIPLINE"] }}'}}</td>
              <td>{{'{{ disc["COMPILER"] }}'}}</td>
              <td v-if="disc['STATUS'] == 0">
                <b class="text-info-color">Новая</b>
              </td>
              <td v-if="disc['STATUS'] == 8">
                <b class="text-primary-color">Исправлена</b>
              </td>
              <td v-if="disc['STATUS'] == 10">
                  <b class="text-success-color">Принята библиотекой</b>
              </td>
              <td>
                <p>{{'{{ disc["CREATEDATE"] }}'}} / {{'{{ disc["UPDATEDATE"] }}'}}</p>
              </td>
              <td>
                <button class="btn btn-lg btn-info" @click="getReport(disc['UCD_FNREC'])">Открыть</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>