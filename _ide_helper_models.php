<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $email
 * @property string $code
 * @property string|null $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken query()
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PasswordResetToken whereEmail($value)
 * @mixin \Eloquent
 */
	class PasswordResetToken extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property mixed $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $student_id
 * @property string $session_id
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\session $session
 * @property-read \App\Models\student $student
 * @method static \Database\Factories\attendanceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|attendance newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|attendance newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|attendance query()
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|attendance whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class attendance extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int $size
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\daysSystem> $daysSystem
 * @property-read int|null $days_system_count
 * @method static \Database\Factories\classroomFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|classroom newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|classroom newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|classroom query()
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|classroom whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class classroom extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int $workshop
 * @property string $name
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $courseTeacher
 * @property-read int|null $course_teacher_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\courseTeacherStudent> $courseTeacherStudent
 * @property-read int|null $course_teacher_student_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\daysSystem> $daysSystem
 * @property-read int|null $days_system_count
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection<int, \Spatie\MediaLibrary\MediaCollections\Models\Media> $media
 * @property-read int|null $media_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Database\Factories\courseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|course newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|course newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|course query()
 * @method static \Illuminate\Database\Eloquent\Builder|course whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|course whereWorkshop($value)
 * @mixin \Eloquent
 * @property string|null $specialty_id
 * @method static \Illuminate\Database\Eloquent\Builder|course whereSpecialtyId($value)
 */
	class course extends \Eloquent implements \Spatie\MediaLibrary\HasMedia {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int $paid
 * @property string $course_teacher_id
 * @property string $student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\student $student
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\taskStudent> $taskStudent
 * @property-read int|null $task_student_count
 * @method static \Database\Factories\courseTeacherStudentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent wherePaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|courseTeacherStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class courseTeacherStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $work_day
 * @property string $end_course
 * @property string $date
 * @property string $start_time
 * @property string $end_time
 * @property string|null $classroom_id
 * @property string $teacher_course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\classroom|null $classroom
 * @property-read \App\Models\teacherCourse $courseTeacher
 * @property-read mixed $day_workshop
 * @method static \Database\Factories\daysSystemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem query()
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereClassroomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereEndCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereTeacherCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|daysSystem whereWorkDay($value)
 */
	class daysSystem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property int $rate
 * @property string|null $feedback
 * @property string $student_id
 * @property string $course_teacher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\teacherCourse $courseTeacher
 * @property-read \App\Models\student $student
 * @method static \Database\Factories\evaluationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation query()
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereFeedback($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|evaluation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class evaluation extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int $size
 * @property string|null $description
 * @property string|null $session_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\session|null $session
 * @method static \Database\Factories\fileFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|file newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|file newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|file query()
 * @method static \Illuminate\Database\Eloquent\Builder|file whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|file whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class file extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $teacher_course_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\teacherCourse|null $courseTeacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\member> $members
 * @property-read int|null $members_count
 * @method static \Database\Factories\groupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|group query()
 * @method static \Illuminate\Database\Eloquent\Builder|group whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereTeacherCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|group whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class group extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $student_id
 * @property string|null $teacher_id
 * @property string $group_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\group $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\message> $messages
 * @property-read int|null $messages_count
 * @property-read \App\Models\student|null $student
 * @method static \Database\Factories\memberFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|member query()
 * @method static \Illuminate\Database\Eloquent\Builder|member whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|member whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class member extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $message
 * @property string|null $member_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\member|null $member
 * @method static \Database\Factories\messageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|message newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|message query()
 * @method static \Illuminate\Database\Eloquent\Builder|message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereMemberId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class message extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property float $cost
 * @property string $date
 * @property string|null $teacher_course_student_id
 * @property string $payment_method
 * @property string $transaction_data
 * @property int $payment_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\paymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereTeacherCourseStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereTransactionData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property float $amount
 * @method static \Illuminate\Database\Eloquent\Builder|payment whereAmount($value)
 */
	class payment extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $title
 * @property string $date
 * @property string $course_teacher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \App\Models\teacherCourse $courseTeacher
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\file> $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\student> $students
 * @property-read int|null $students_count
 * @method static \Database\Factories\sessionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|session newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|session newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|session query()
 * @method static \Illuminate\Database\Eloquent\Builder|session whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|session whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class session extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $specialty_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $courseTeacher
 * @property-read int|null $course_teacher_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacher> $teachers
 * @property-read int|null $teachers_count
 * @method static \Database\Factories\specialtyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|specialty newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|specialty newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|specialty query()
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereSpecialtyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|specialty whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class specialty extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $first_name
 * @property string $last_name
 * @property string $user_name
 * @property string $phoneNumber
 * @property int $age
 * @property string $email
 * @property string $password
 * @property int $gender
 * @property string|null $photo
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\attendance> $attendances
 * @property-read int|null $attendances_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $courseTeacher
 * @property-read int|null $course_teacher_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\member> $members
 * @property-read int|null $members_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\session> $sessions
 * @property-read int|null $sessions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\taskStudent> $taskStudent
 * @property-read int|null $task_student_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\studentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|student newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|student newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|student onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|student query()
 * @method static \Illuminate\Database\Eloquent\Builder|student whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|student withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|student withoutTrashed()
 * @mixin \Eloquent
 */
	class student extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int $mark
 * @property string $date
 * @property string $course_teacher_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\taskFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|task query()
 * @method static \Illuminate\Database\Eloquent\Builder|task whereCourseTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|task whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class task extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property int $mark
 * @property float $studentMark
 * @property string $date
 * @property string|null $course_teacher_student_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\taskStudentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent query()
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereCourseTeacherStudentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereStudentMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|taskStudent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class taskStudent extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property string $phoneNumber
 * @property string|null $photo
 * @property string $password
 * @property string $user_name
 * @property string|null $speciality_id
 * @property int $is_admin
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\course> $courses
 * @property-read int|null $courses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\session> $session
 * @property-read int|null $session_count
 * @property-read \App\Models\specialty|null $specialty
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\teacherCourse> $teacherCourse
 * @property-read int|null $teacher_course_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Passport\Token> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\teacherFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|teacher newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher query()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereSpecialityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereUserName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacher withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|teacher withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|teacher whereDescription($value)
 */
	class teacher extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $teacher_id
 * @property string $course_id
 * @property int $total_days
 * @property string $level
 * @property float $total_cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\attendance> $attendance
 * @property-read int|null $attendance_count
 * @property-read \App\Models\course $course
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\courseTeacherStudent> $courseTeacherStudent
 * @property-read int|null $course_teacher_student_count
 * @property-read \App\Models\daysSystem|null $daysSystem
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\evaluation> $evaluation
 * @property-read int|null $evaluation_count
 * @property-read \App\Models\group|null $group
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\session> $sessions
 * @property-read int|null $sessions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\student> $students
 * @property-read int|null $students_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\teacher|null $teacher
 * @method static \Database\Factories\teacherCourseFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse query()
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereCourseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereTeacherId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereTotalCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereTotalDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|teacherCourse whereUpdatedAt($value)
 */
	class teacherCourse extends \Eloquent {}
}

