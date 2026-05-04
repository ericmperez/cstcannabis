<?php
/**
 * CST_Auto_Enrollment — auto-enroll new students in the cannabis course.
 *
 * The portal currently exposes a single free course ("curso-cannabis"),
 * so signing up only makes sense if it leaves the user already enrolled.
 * Without this, new accounts land on an empty Tutor dashboard with
 * zero courses and no obvious next step.
 *
 * Hooks `tutor_after_student_signup`, looks up the cannabis course by
 * slug, and uses Tutor's own enrollment helper. After enrollment the
 * user is redirected to the course player instead of the dashboard.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class CST_Auto_Enrollment {

    private const COURSE_SLUG = 'curso-cannabis';

    public function __construct() {
        add_action( 'tutor_after_student_signup', [ $this, 'enroll_in_cannabis_course' ], 10, 1 );
        add_filter( 'tutor_student_register_redirect_url', [ $this, 'redirect_to_course' ], 10, 1 );
    }

    public function enroll_in_cannabis_course( int $user_id ): void {
        if ( ! function_exists( 'tutor_utils' ) ) {
            return;
        }
        $course = get_page_by_path( self::COURSE_SLUG, OBJECT, 'courses' );
        if ( ! $course || 'publish' !== $course->post_status ) {
            return;
        }
        if ( tutor_utils()->is_enrolled( $course->ID, $user_id ) ) {
            return;
        }
        tutor_utils()->do_enroll( $course->ID, 0, $user_id );
    }

    /**
     * Send the freshly registered student to the course they're now
     * enrolled in instead of the empty dashboard.
     */
    public function redirect_to_course( $url ) {
        $course = get_page_by_path( self::COURSE_SLUG, OBJECT, 'courses' );
        if ( $course && 'publish' === $course->post_status ) {
            return get_permalink( $course->ID );
        }
        return $url;
    }
}
