<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 */
class payment extends Model
{
    use HasFactory ,HasUuids;


    
}
