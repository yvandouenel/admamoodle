<?php
// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/renderer.php');


class theme_adma_core_course_renderer extends core_course_renderer {
  /**
   * Returns HTML to print list of available courses for the frontpage
   *
   * @return string
   */
  public function frontpage_available_courses() {
    global $CFG;
    require_once($CFG->libdir. '/coursecatlib.php');

    $chelper = new coursecat_helper();
    $chelper->set_show_courses(self::COURSECAT_SHOW_COURSES_EXPANDED)->
    set_courses_display_options(array(
      'recursive' => true,
      'limit' => $CFG->frontpagecourselimit,
      'viewmoreurl' => new moodle_url('/course/index.php'),
      'viewmoretext' => new lang_string('fulllistofcourses')));

    $chelper->set_attributes(array('class' => 'frontpage-course-list-all d-flex '));
    $courses = coursecat::get(0)->get_courses($chelper->get_courses_display_options());
    $totalcount = coursecat::get(0)->get_courses_count($chelper->get_courses_display_options());
    if (!$totalcount && !$this->page->user_is_editing() && has_capability('moodle/course:create', context_system::instance())) {
      // Print link to create a new course, for the 1st available category.
      return $this->add_new_course_button();
    }
    return $this->coursecat_courses($chelper, $courses, $totalcount);
  }

}