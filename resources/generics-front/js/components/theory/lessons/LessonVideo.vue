<!--
@Component:
    lesson-video
@Description:
    Video displaying
@CalledComponents:
    1 - pomodoro-line
@ApiRoutes:
@WebRoutes:
    /dashboard/materias/{courseId}/{relatedId}
@Props:
    lesson	: lesson information
    course	: course information
    related	: lessons related to  course
@Constants:
@TODO:
-->

<template>
	<div style="margin-top:100px">
		<section class="Module container">
			<div class="row">
				<div class="col-sm-12">
					<div class="Module-video">
						<div class="embed-responsive embed-responsive-16by9">
							<iframe class="embed-responsive-item" :src="'https://www.youtube.com/embed/'+lesson.video_id+'?rel=0&amp;controls=0&amp;showinfo=0'" frameborder="0" allowfullscreen></iframe>
						</div>
					</div>
					<div class="text-right u-m-b-10">
						Estudado?
						<span v-if="lesson.userMade">
							<toggle-button @change="emitUserMade"
										   :value="true"
										   color="#a6ce38"
										   :width="70"
										   :labels="{checked: 'Sim', unchecked: 'Não'}"
							/>
						</span>
						<span v-else >
							<toggle-button @change="emitUserMade"
										   color="#a6ce38"
										   :width="70"
										   :value="false"
										   :labels="{checked: 'Sim', unchecked: 'Não'}"
							/>
						</span>

					</div>

					<div class="Card-content">
						<div class="Card Card--module Card--fixedBorder">
							<div class="Card-info">
								<div class="Card-titleArea pull-left">
									<h2 class="Card-title">{{ lesson.title }}</h2>
								</div>
							</div>
							<div class="Card-content">
								<div class="row">
									<div class="col-sm-8">
										<p class="Card-text">{{ lesson.details }}</p>
										<div class="Module-comments">
											<h4 class="Module-commentsTitle">Comentários</h4>
											<div class="fb-comments" data-numposts="3" data-width="100%" data-order-by="social"></div>
										</div>
									</div>
									<div class="col-sm-4">
										<h4 class="List-title">Prepare-se para os próximos vídeos:</h4>
										<ul v-for="rel in related" class="List list-unstyled">
											<hr />
											<li class="List-item List-item--border">
												<div class="List-content">
													<div class="List-icon">
														<i class="Icon Icon--playCircleBefore" :data-color="course.color"></i>
													</div>
													<div class="List-details List-details--block">
														<div v-if="rel.userMade">
														<span style="text-decoration: line-through;">
															<a style="text-decoration: overline;" :href="'/dashboard/materias/'+course.id+'/'+rel.id" class="List-link" :title="rel.title">{{ rel.title }}</a>
														</span>
														</div>
														<div v-else>
															<a style="text-decoration: overline;" :href="'/dashboard/materias/'+course.id+'/'+rel.id" class="List-link" :title="rel.title">{{ rel.title }}</a>
														</div>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</div>
</template>



<script>


    export default {

        props: {
            lesson: {
                type: Object
            },
            course: {
                type: Object
            },
            related: {
                type: [Object, Array]
            }
        },

        mounted() {

        },

        data() {
            return {

            }
        },

        methods: {
            emitUserMade: function() {
                this.$emit('child-user-made');
            }
        }
    }

</script>
