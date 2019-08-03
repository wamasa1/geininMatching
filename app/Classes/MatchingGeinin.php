<?php
namespace App\Classes;

use App\Geinin;

class MatchingGeinin
{
    private $auth_geinin;
    private $role;
    private $creater;

    public function __construct($auth_geinin)
    {   
        $this->auth_geinin = $auth_geinin;
        //roleのMatching(例えばボケに対しては、ツッコミと「こだわらない」芸人をマッチング)
        $role = $auth_geinin->role;
        switch ($role) {
            case 'ボケ':
            case 'ツッコミ':
                $role_boolean = true;
                break;
            case 'こだわらない':
                $role_boolean = false;
                break;
        }
        $this->role = $role;
        $this->role_boolean = $role_boolean;

        //createrのMatching
        $creater = $auth_geinin->creater;
        switch ($creater) {
            case '自分が作る':
                $creater = '相方に作ってほしい';
                break;
            case '相方に作ってほしい':
                $creater = '自分が作る';
                break;
        }
        $this->creater = $creater;
    }

    // マッチング率100%の芸人のデータを取得
    public function getPartners()
    {   
        // これにより引数なしでgetメソッドが使える
        $auth_geinin = $this->auth_geinin;
        $role = $this->role;
        $creater = $this->creater;

        $partners = Geinin::where('id', '!=', $auth_geinin->id)
            ->where('activity_place', $auth_geinin->activity_place)
            ->where('genre', $auth_geinin->genre)
            ->when($this->role_boolean, function ($query) use ($role) {
                return $query->where('role', '!=', $role);
            })
            ->where('creater', $creater)
            ->where('target', $auth_geinin->target)
            ->inRandomOrder()->get();

        return $partners;
    }
    //マッチング率80%の芸人のデータを取得
    public function getEightyPartners()
    {   
        // これにより引数なしでgetメソッドが使える
        $auth_geinin = $this->auth_geinin;
        $role = $this->role;
        $creater = $this->creater;

        $eighty_partners = Geinin::where('id', '!=', $auth_geinin->id)
            ->where('activity_place', $auth_geinin->activity_place)
            ->where('genre', $auth_geinin->genre)
            ->when($this->role_boolean, function ($query) use ($role) {
                return $query->where('role', '!=', $role);
            })
            ->where('creater', $creater)
            ->where('target', '!=', $auth_geinin->target)
            ->inRandomOrder()->get();

        return $eighty_partners;
    }
    //マッチング率60%の芸人のデータを取得
    public function getSixtyPartners()
    {   
        // これにより引数なしでgetメソッドが使える
        $auth_geinin = $this->auth_geinin;
        $role = $this->role;
        $creater = $this->creater;

        $sixty_partners = Geinin::where('id', '!=', $auth_geinin->id)
            ->where('activity_place', $auth_geinin->activity_place)
            ->where('genre', $auth_geinin->genre)
            ->when($this->role_boolean, function ($query) use ($role) {
                return $query->where('role', '!=', $role);
            })
            ->where('creater', '!=', $creater)
            ->where('target', '!=', $auth_geinin->target)
            ->inRandomOrder()->get();
            
        return $sixty_partners;
    }
}