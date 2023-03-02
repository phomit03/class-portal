<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $keyType ='integer';

    protected $fillable = [
        'name', 'title', 'room', 'section','class_code'
    ];

    /**
     * Capitalizes the first character of the string uppercase
     * to keep consistency
     *
     * @param String $value
     * @return string
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    /**
     * Capitalizes the first character of the string uppercase
     * to keep consistency
     *
     * @param String $value
     * @return string
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = ucwords($value);
    }

    /**
     * Capitalizes the first character of the string uppercase
     * to keep consistency
     *
     * @param String $value
     * @return string
     */
    public function setRoomAttribute($value)
    {
        $this->attributes['room'] = ucwords($value);
    }

    /**
     * Capitalizes the first character of the string uppercase
     * to keep consistency
     *
     * @param String $value
     * @return string
     */
    public function setSectionAttribute($value)
    {
        $this->attributes['section'] = ucwords($value);
    }

    /**
     * Many-to-many relationship between classes and users
     *
     * @return Response
     */
    public function users()
    {
        return $this->belongsToMany(User::class,"classes_users","class_id","user_id" );
    }

    public function usersIsStudent()
    {
        return $this->belongsToMany(User::class,"classes_users","class_id","user_id" )
            ->where('users.role', 'student');
    }

    public function usersIsTeacher()
    {
        return $this->belongsToMany(User::class,"classes_users","class_id","user_id" )
            ->where('users.role', 'teacher');
    }

    /*public function class_user(){
        return $this->hasOne(classes_user::class, 'class_id', 'id');
    }

    public function lecturers(){
        return $this->hasManyThrough(User::class, Assignment::class, 'teacher_id','id');
    }*/
    /**
     * Subject that has many to this class
     *
     * @return Response
     */

    public function subjects()
    {
        return $this->belongsToMany(Subject::class,"classes_subjects","class_id","subject_id");
    }

    public function assignments(){
        return $this->hasMany(Assignment::class, 'class_id', 'id');
    }

}
