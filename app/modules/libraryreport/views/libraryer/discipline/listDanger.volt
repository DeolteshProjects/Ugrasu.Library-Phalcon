<!-- Форма вывода результатов поиска -->
<div class="small-12 medium-12 large-12 columns">
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
            <tr v-for="(disc, index) in disciplinesStarted[2]">
              <td>{{'{{ index+1 }}'}}</td>
              <td>{{'{{ disc["DISCIPLINE"] }}'}}</td>
              <td>{{'{{ disc["COMPILER"] }}'}}</td>
              <td v-if="disc['STATUS'] == 2">
                <b class="text-danger-color">Отклонена библиотекой</b>
              </td>
              <td>
                <p>{{'{{ disc["CREATEDATE"] }}'}}</p>
                <p>{{'{{ disc["UPDATEDATE"] }}'}}</p>
              </td>
              <td>
                <button class="btn btn-lg btn-info" @click="getReport(disc['UCD_FNREC'])">Открыть</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>