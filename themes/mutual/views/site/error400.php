        <section class="content-header">
          <h1>
            Error 400
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-yellow"></i> Lo sentimos! Página no encontrada.</h3>
              <p>
                No pudimos encontrar la página que esta buscando.
                Mientras tanto puede <a href=<?php echo Yii::app()->createUrl('/site/index');?>>retornar al inicio</a> de la aplicación.
              </p>
              <form class='search-form' style="display: none;">
                <div class='input-group'>
                  <input type="text" name="search" class='form-control' placeholder="Search"/>
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div><!-- /.input-group -->
              </form>
            </div><!-- /.error-content -->
          </div><!-- /.error-page -->
        </section><!-- /.content -->
