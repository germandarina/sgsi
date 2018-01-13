<div class="box-body">
    <input type="hidden" name="analisis_id" id="analisis_id" value="<?= $analisis->id?>">
    <input type="hidden" name="grupo_id" id="grupo_id" value="<?= $grupo->id?>">
    <input type="hidden" name="control_id" id="control_id">
    <div class="col-sm-1">

    </div>
    <div class="col-sm-10">
        <div class="br-wrapper br-theme-bars-square">
            <select id="rating" name="rating" autocomplete="off" style="display: none;">
                <option value=""></option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
<!--            <div class="br-widget">-->
<!--                <a href="#" data-rating-value="1" data-rating-text="1" class="">1</a>-->
<!--                <a href="#" data-rating-value="2" data-rating-text="2" class="">2</a>-->
<!--                <a href="#" data-rating-value="3" data-rating-text="3" class="">3</a>-->
<!--                <a href="#" data-rating-value="4" data-rating-text="4" class="">4</a>-->
<!--                <a href="#" data-rating-value="5" data-rating-text="5" class="">5</a>-->
<!--            </div>-->
        </div>
    </div>
</div>