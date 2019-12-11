<?php
    date_default_timezone_set('Africa/Johannesburg');

    define("DB_HOST", "localhost");
    define("DB_USER", "cashtwo5_balace");
    define("DB_PASS", "Cameroonian1");
    define("DB_NAME", "db_api_test");
    
    define("DB_USER_TBL", "tbl_users");
    define("DB_REPORT_TBL", "tbl_reports");
    define("DB_APPEAL_TBL", "tbl_appeals");
    define("DB_CONTACT_TBL", "tbl_contacts");
    define("DB_ENROLLED_TBL", "tbl_enrolled");
    define("DB_FACILITATED_TBL", "tbl_facilitated");
    define("DB_ASSESSED_TBL", "tbl_assessed");
    define("DB_INT_MODERATED_TBL", "tbl_int_moderated");
    define("DB_EXT_MODERATED_TBL", "tbl_ext_moderated");
    define("DB_ACHIEVED_TBL", "tbl_achieved");
    define("DB_QUESTION_TBL", "tbl_question");
    define("DB_EXAMS_TBL", "tbl_exams");
    
    define("DB_USER_DOC_TBL", "tbl_user_docs");
    define("DB_ATTENDANCE_TBL", "tbl_attendance");

    // For Seminars
    define("DB_SEMINAR_TBL", "tbl_seminar");
    define("DB_ATTENDEE_TBL", "tbl_attendee");
    define("DB_SPEAKER_TBL", "tbl_speaker");
    define("DB_SPONSOR_TBL", "tbl_sponsor");                            // For registered sponsors
    define("DB_SPONSORSHIP_TBL", "tbl_sponsorship");                    // Table that holds packages selected by sponsors
    define("DB_SPONSORSHIP_ADVERT_TBL", "tbl_sponsorship_advert");      // Table for sponsorship adverts/packages
    define("DB_EXHIBITOR_TBL", "tbl_exhibitor");                        // For registered exhibitors. Exhibitor (user) account(s)
    define("DB_EXHIBITION_TBL", "tbl_exhibition");                      // For exhibitor package payments
    define("DB_EXHIBITION_TICKET_TBL", "tbl_exhibition_ticket");        // For exhibition tickets types and info
    define("DB_EVENT_TICKET_TBL", "tbl_event");                         // For seminar/event packages
    define("DB_ATTENDIZE_IVP_EVENT_TBL", "events");                     // For Attendize Events. ToDo: Change table name accordingly
    define("DB_ATTENDIZE_IVP_TICKET_TBL", "tickets");                   // For Attendize Events. ToDo: Change table name accordingly
    
    define("QUESTION_TYPE_MULTI", "multi");                             // Question type for questions with multi choices
    define("QUESTION_TYPE_SHORT", "short");                             // Question type for questions with short answers => text field
    define("QUESTION_TYPE_LONG", "long");                               // Question type for questions with long answers => textarea
    define("QUESTION_TYPE_UPLOAD", "upload");                           // Question type for file upload like e.g workplace assignment
    define("QUESTION_TYPE_DOWNLOAD", "download");                       // Question type for file download like programme manual
    define("QUESTION_TYPE_TEXT", "text");                               // Question type for text display
    
    define("LMS_STATUS_REGISTERED", "0");
    define("LMS_STATUS_ENROLLED", "1");
    define("LMS_STATUS_ASSESSED", "2");
    define("LMS_STATUS_MODERATED", "3");
    define("LMS_STATUS_EXT_MODERATED", "4");                            // Externally moderated
    define("LMS_STATUS_PRE_ACHIEVED", "5");
    define("LMS_STATUS_ACHIEVED", "6");
    
    
    define("LMS_LOGIN_SECRET", "85236874135685312,0");
    
    define("MODERATOR_MODERATION_PERCENTATION", 30);                    // Percentage of assessed learners to be moderated = 30%
    
    define("GENERIC_EMAIL_HOST", "ivp.en3ticket.com");
    define("GENERIC_FROM_EMAIL", "admin@ivp.en3ticket.com");
    define("GENERIC_REPLY_EMAIL", "admin@ivp.en3ticket.com");
    define("GENERIC_EMAIL_PWD", "BVYuZQkLKz9YEWy");
    define("GENERIC_FROM_NAME", " AMI Admin ");
    
    // ToDo: Update accordingly for other programmes and domains
//     define("GENERIC_EMAIL_HOST", "mail.en3ticket.com");        
//     define("GENERIC_FROM_EMAIL", "admin@en3ticket.com");
//     define("GENERIC_REPLY_EMAIL", "admin@en3ticket.com");
//     define("GENERIC_EMAIL_PWD", 'Z=gEOWP[+TSu94&5)5+852$§"');
    
    
    define("LMS_SLMS_MAIN_HOMEPAGE", "https://www.en3ticket.com");
    define("LMS_PROGRAMME_PARENT_FOLDER", "/msep/");                    // used to redirect user after login to the right user role account
    define("LMS_PROGRAMME_ABS_PATH", "https://ivp.en3ticket.com/");// used for invitation, password reset and program specific login(sent after registration) links 
?>