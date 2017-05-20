<?php 
	use app\components\IdevFunctions;
	use yii\widgets\ActiveForm;
?>	
<div class="content">
  <div class="row">
		<div class="col-lg-9">
			<div class="panel panel-flat">
				<div class="form-group">
					<label for="post_title"><?=Yii::t('idev','Name')?></label>
					<input type="text" name="Post[name]" class="form-control">
				</div>
				<div class="form-group">
					<label><?=Yii::t('idev','Content')?></label>
					<textarea class="form-control" name="Post[content]" rows="10"></textarea>
				</div>
			</div>
		</div>

		<div class="col-lg-3 pl-0">
			<div class="panel panel-flat">
				<div class="form-group">
					<label><?=Yii::t('idev','Category')?></label>
					<select class="form-control">
						<option value="0"><?=Yii::t('idev','No')?></option>
					</select>
				</div>
			</div>
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Parametrlar<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-lg-4 text-semibold"><h6 class="text-semibold">Xarakter</h6></label>
						<div class="col-lg-8">
							<div class="checkbox checkbox-switch">
								<label>
									<input type="checkbox" data-on-color="default" data-off-color="danger" data-on-text="Pozitiv" data-off-text="Negativ" class="switch" checked="checked">
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4 text-semibold"><h6 class="text-semibold">Obuna</h6></label>
						<div class="col-lg-8">
							<div class="checkbox checkbox-switch">
								<label>
									<input type="checkbox" data-on-color="default" data-off-color="success" data-on-text="Oddiy" data-off-text="Obunali" class="switch" checked="checked">
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-4 text-semibold"><h6 class="text-semibold">Muhimmi?</h6></label>
						<div class="col-lg-8">
							<div class="checkbox checkbox-switch">
								<label>
									<input type="checkbox" data-on-color="default" data-off-color="success" data-on-text="Yo'q" data-off-text="Muhim-" class="switch" checked="checked">
								</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h5 class="panel-title">Reklama<a class="heading-elements-toggle"><i class="icon-more"></i></a></h5>
				</div>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-lg-4 text-semibold"><h6 class="text-semibold">PR</h6></label>
						<div class="col-lg-8">
							<div class="checkbox checkbox-switch">
								<label>
									<input type="checkbox" data-on-color="default" data-off-color="danger" data-on-text="Ha" data-off-text="Yo'q" class="switch" checked="checked">
								</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<input class="form-control" type="date" name="date">
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-12">
							<input class="form-control" type="time" name="time">
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-flat">
				<div class="panel-body">
					<div class="col-md-12 btn-group">
                    	<button type="button" class="btn btn-primary dropdown-toggle" submit="submit"><i class="icon-paperplane position-left"></i> Yuborish</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>