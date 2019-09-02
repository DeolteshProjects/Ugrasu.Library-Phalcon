<!-- Заголовок модуля -->
<div class="modules-header">
  <div class="header">
    <div class="header-title">
      <h4 class="title">Модуль поиска литературы в научной библиотеке ЮГУ</h4>
      <template class="text-danger-color" v-if="full == 0">
        Для продолжения добавьте хотя-бы
        <b class="text-danger-color" v-if="(countBBook == 0) && (countABook == 0)">
          по одной ОСНОВНОЙ и ДОПОЛНИТЕЛЬНОЙ литературе
        </b>
        <b class="text-danger-color" v-else-if="countBBook == 0">
          еще одну ОСНОВНУЮ литературу
        </b>
        <b class="text-danger-color" v-else>
          еще одну ДОПОЛНИТЕЛЬНУЮ литературу
        </b>
      </template>
    </div>
    <div class="header-content">
        <small>Библиографическая справка на {{'{{ changed.year }}'}} год набора. <b> {{'{{ speccode }}'}} - {{'{{ speciality }}'}}</b>. {{'{{ changed.forma }}'}} форма обучения. <b>{{'{{ discipline }}'}}</b></small>
      <!-- -->
    </div>
  </div>
</div>
<!-- Тело модуля -->
<div class="modules-content">
  <!-- Форма поиска -->
  <div class="block-search-form small-12 medium-12 large-4 columns main-menu-module">
    <div class="form">
      <div class="form-title">
        <h5>Форма поиска литературы</h5>
      </div>
      <!-- Автор -->
      <div class="form-control col-md-12">
        <label class="col-md-12 form-label form-control">Автор <font size="2">(Составитель/Соавтор/Рецезент/Редактор)
          </font></label>
        <input v-model="search.author" id="input-author" class="col-md-12 input form-input form-control" type="text"
          placeholder="Сафонов..." name="author">
      </div>

      <!-- Заглавие -->
      <div class="form-control col-md-12">
        <label class="col-md-12 form-label form-control">Заглавие</label>
        <input v-model="search.title" id="input-title" class="col-md-12 input form-input form-control" type="text"
          placeholder="Математическая..." name="title">
      </div>

      <!-- Ключевые слова -->
      <div class="form-control col-md-12">
        <label class="col-md-12 form-label form-control">Ключевые слова</label>
        <input v-model="search.keyWords" id="input-keyWords" class="col-md-12 input form-input form-control" type="text"
          placeholder="Программирование..." name="keyWords">
      </div>

      <!-- Стоп слова -->
      <div class="form-control col-md-12">
        <label class="col-md-12 form-label form-control text-danger-color">Cтоп слова (через запятую)</label>
        <input v-model="search.stopWords" id="input-stopWords" class="col-md-12 input form-input form-control"
          type="text" placeholder="Экономика..." name="stopWords">
        <p><small class="small-description text-warning-color">Найденная литература содержащая в себе стоп слова будет
            исключена из результатов поиска</small></p>
      </div>

      <!-- Фильтры -->
      <div class="form-control col-md-12">
        <label class="small-8 medium-8 large-8 text-info-color">Использование фильтров
          <input v-model="search.filters" id="input-filters" class="input form-input form-control text-info-color btn"
            type="checkbox" name="filters">
        </label>
      </div>

      <div class="form-control col-md-12">
        <button v-on:click="checkSearch()" class="col-md-12 btn btn-lg btn-info" name="literatureSearch">Поиск</button>
      </div>
      <div class="form-control col-md-12" v-if="countAllBook > 0">
        <button v-on:click="status = 2" class="col-md-12 btn btn-lg btn-info" name="show">Перейти к состаляемой справке</button>
      </div>
    </div>
  </div>
</div>

<!-- Форма вывода результатов поиска -->
<div class="block-search-result small-12 medium-12 large-8 columns">
  <!-- <center><h1>Обед до <b class="text-danger-color">14:00</b></h1></center> -->
  <table id="result-table" cellspacing="0">
    <tbody v-for="(res, index) in search.result">
      <tr v-if="res.Author != null">
        <td class="td-left">{{'{{ index+1 }}'}}</td>
        <td class="td_right"><b>{{'{{ res.Author }}'}}</b> {{'{{ res.SmallDescription }}'}}
          <p>В библиотеке присутствует: {{'{{ res.NumberOfCopies }}'}} шт.</p>
          <p>
            <button @click="addBook(index , 0)" class="btn btn-success">Добавить в основную литературу</button>
            <button @click="addBook(index , 1)" class="btn btn-warning">Добавить в дополнительную литературу</button>
          </p>
        </td>
      </tr>
    </tbody>
  </table>
</div>