<div id="app">
  <center>Здесь вы можете скачать инструкцию к модулю библиографических справок в форматах:</center>
  <div class="small-12 medium-6 large-6 columns main-menu-module" @click="downPDF()">
    <div class="main-menu-modules-img">
      <img src="https://tehnikasluha.ru/images/pdf-ico.png" alt="Панель администратора">
    </div>
    <div class="main-menu-modules-description">
      Скачать в формате <i class="text-danger-color">PDF!</i> </div>
  </div>

  <div class="small-12 medium-6 large-6 columns main-menu-module" @click="downWord()">
    <div class="main-menu-modules-img">
      <img src="https://png.icons8.com/ios/1600/007AFF/microsoft-word-filled" alt="Word">
    </div>
    <div class="main-menu-modules-description">
      Скачать в формате <i class="text-info-color">Word</i> </div>
  </div>
</div>