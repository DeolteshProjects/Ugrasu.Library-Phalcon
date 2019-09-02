<!-- Панель сохранения справки-->
<div>
  <button @click="edit = 1, status = 2, editReport(report[0]['UCD_FNREC'])" v-if="(report[0]['STATUS']) < 10"
    class="btn btn-warning">Изменить</button>
  <button @click="update(fnrec)" v-if="edit == 1"
    class="btn btn-warning">Сохранить изменения</button>
  <button v-if="edit == 1" @click="status = 1" class="btn btn-warning">Добавить литературу</button>
  <button class="btn btn-info" @click="getReports(report[0]['YEARED'], report[0]['SPECIALITYCODE'], report[0]['FORMA'])">Перейти к другим справкам по этому направлению</button>
</div>