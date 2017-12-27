  
        <section class="content-header">
          <h1>
            Error 500
          </h1>
        </section>

        <!-- Main content -->
        <section class="content">

          <div class="error-page">
            <h2 class="headline text-red">500</h2>
            <div class="error-content">
              <h3><i class="fa fa-warning text-red"></i> Lo sentimos! Sucedió algo inesperado.</h3>
              <p>
                Estaremos trabajando para resolverlo.
                Mientras tanto puede <a href=<?php echo Yii::app()->createUrl('/site/index');?>>retornar al inicio</a> de la aplicación.
              </p>
              <form class='search-form' style="display: none;">
                <div class='input-group'>
                  <input type="text" name="search" class='form-control' placeholder="Search"/>
                  <div class="input-group-btn">
                    <button type="submit" name="submit" class="btn btn-danger btn-flat"><i class="fa fa-search"></i></button>
                  </div>
                </div><!-- /.input-group -->
              </form>
            </div>
          </div><!-- /.error-page -->

        </section><!-- /.content -->
