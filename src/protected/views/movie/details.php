<?php

/* @var $this MovieController */
/* @var $actorDataProvider LibraryDataProvider */
/* @var $details stdClass */

$this->pageTitle = $details->label.' ('.$details->year.')';

?>
<div class="item-details">
	<div class="row">
		<div class="span3">
			<?php echo CHtml::image(new ThumbnailMovie($details->thumbnail, 
					Thumbnail::SIZE_LARGE), '', array(
				'class'=>'item-thumbnail hidden-phone',
			)); ?>
			
			<div class="item-links">
				<h3>Watch / Download</h3>
				
				<p>
					Click the Watch button to start streaming the video (open 
					the file in your favorite media player), or download the 
					individual files for later viewing using the links below it.
				</p>
				
				<?php echo TbHtml::linkButton('Watch', array(
					'color'=>TbHtml::BUTTON_COLOR_SUCCESS,
					'size'=>TbHtml::BUTTON_SIZE_LARGE,
					'url'=>array('getMoviePlaylist', 'movieId'=>$details->movieid),
					'class'=>'fontastic-icon-play',
				)); ?>
				
				<div class="item-links">
					<?php

					$numLinks = count($movieLinks);
					$linkOptions = array('class'=>'fontastic-icon-disc');

					foreach ($movieLinks as $k=> $link)
					{
						if ($numLinks == 1)
							$label = 'Download';
						else
							$label = 'Download (part #'.(++$k).')';

						echo CHtml::tag('p', array(), CHtml::link($label, $link, $linkOptions));
					}

					?>
				</div>
			</div>
		</div>
		
		<div class="span9 item-description">
			<div class="item-top row-fluid">
				<div class="item-title span6">
					<h2>
						<a href="http://www.imdb.com/title/<?php echo $details->imdbnumber; ?>">
							<?php echo $details->label; ?>
						</a>
					</h2>

					<p>(<?php echo $details->year; ?>)</p>

					<p class="tagline">
						<?php echo $details->tagline; ?>
					</p>

				</div>
				
				<div class="span6 hidden-phone">
					<?php $this->widget('MediaFlags', array(
							'streamDetails'=>$details->streamdetails)); ?>
				</div>
			</div>
			
			<div class="item-info clearfix">
				
				<?php
				
				$rating = $details->rating;
				
				if ((int)$rating > 0)
					$this->renderPartial('/videoLibrary/_rating', array(
						'rating'=>$rating, 'votes'=>$details->votes));
				
				?>

				<div class="pull-left">

					<div class="item-metadata clearfix">

						<p><?php echo implode(' / ', $details->genre); ?></p>
						<p><?php echo (int)($details->runtime / 60); ?> min</p>

						<?php

						// MPAA rating is not always available
						if ($details->mpaa)
							echo '<p>MPAA rating: '.$details->mpaa.'</p>';
						
						?>
					</div>

				</div>
			</div>
			
			<h3>Plot</h3>
			
			<div class="item-plot">
				<p><?php echo $details->plot; ?></p>
			</div>
			
			<h3>Cast</h3>
			
			<div class="row-fluid">
				<?php $this->widget('zii.widgets.CListView', array(
					'dataProvider'=>$actorDataProvider,
					'itemView'=>'/videoLibrary/_actorGridItem',
					'itemsTagName'=>'ul',
					'itemsCssClass'=>'thumbnails actor-grid',
					'enablePagination'=>false,
					'template'=>'{items}'
				)); ?>
			</div>
		</div>
	</div>
</div>
