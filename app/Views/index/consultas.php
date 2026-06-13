		<section id="hero_in" class="courses start_bg_zoom">
			<div class="wrapper">
				<div class="container">
					<h1 class="fadeInUp animated"><span></span>Consultar Radicado</h1>
                    
				</div>
			</div>
		</section>
		<!--/hero_in-->

		<div class="bg_color_1" style="transform: none;">
			<div class="container margin_60_35" style="transform: none;">
			<?php echo form_open(base_url('consultas'), ['class' => '', 'id' => 'form_radicar', 'role' => 'form'], ['consultar' => 1]); ?>
				<div class="row justify-content-between">
					
					<h4>Consultar radicado.</h4>			
					<p>Por favor, escriba el radicado con mayúsculas y minúsculas como fue generado.</p>
					<div class="col-lg-8">
						<span class="input">
							<input class="input_field" value="<?php echo (isset($data['token']) && $data['token'])?($data['token']):'' ?>" type="text" id="numeroradicado" name="numeroradicado">
							<label class="input_label">
								<span class="input__label-content">Radicado</span>
							</label>
						</span>
					</div>
					<div class="col-lg-4" style="padding-top:20px">
						<input type="submit" value="Buscar" class="btn_1 rounded" id="submit-contact">
					</div>
				</div>						
			<?php echo form_close(); ?>
					
						<?php if(isset($data['radicado']) && $data['radicado']):?>
						<div style="padding-top:50px">
						<h4>Información encontrada.</h4>	
						<article class="blog wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
							<div class="row g-0">
								<div class="col-lg-7">
									<figure>
										<img src="<?php echo base_url('/template/img/blog-1.jpg'); ?>" alt="">
									</figure>
								</div>
								<div class="col-lg-5">
									<div class="post_info">
										<p><?php echo '<b>Fecha de solicitud:</b><br>'.$data['radicado']['fecha_solicitud']; ?></p>
										<hr>
										<p><?php echo '<b>Tipo de solicitud:</b><br>'.$data['radicado']['tipo_desc']; ?></p>
										<hr>
											<h3><b>Nº de radicado:</b><?php echo '<br>'.$data['radicado']['token']; ?></h3>
									</div>
								</div>
							</div>
						</article>
						</div>
						<?php endif; ?>
					
				</div>
			
			</div>
			<!-- /container -->
		</div>
        
        
