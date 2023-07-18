<?php
use App\Models\Option;
use App\Models\Post;
use App\Models\PostExtra;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
// use Config;

/**
* Create a post key and value
* @param sting, string
*
*/
function set_post_key_value($post_id, $key, $value){
    try {
        $pextra = PostExtra::where(['post_id' => $post_id, 'key_name' => $key])->first();
        if($pextra){
            $old = array(
                'key_value' => $value
            );
            PostExtra::where(['post_id' => $post_id, 'key_name' => $key])->update($old);
        }else{
            PostExtra::insert(array(
                'post_id'    => $post_id,
                'key_name'   => $key,
                'key_value'  => $value,
                'created_at' => date("y-m-d H:i:s", strtotime('now')),
                'updated_at' => date("y-m-d H:i:s", strtotime('now')),
            ));
        }

        return true;
    } catch (\Exception $e) {
        return false;
    }    
}


/**
 * Get post extra
 *
 * @param post_id, key_name
 * @return string
 */
function get_post_extra($post_id, $key_name){
    $data = '';
    $get_post_extra = PostExtra::where(['post_id' => $post_id, 'key_name' => $key_name])->first();
    if(!empty($get_post_extra)){
        $data = $get_post_extra->key_value;
    }
    
    return $data;
}

/**
 * Get post data
 *
 */
function get_post_data($type = '', $request = null){
    $order_data = array();

    if (empty($type)) {
        return $order_data;
    }

    $query = (new Post)->newQuery();
    if (!empty($request) && $request->has('s') && $request->filled('s')) {
        $query->where('post_title' , 'like' , '%'.$request->s.'%');
    }

    if($type == 'review'){
        $post = $query->where('post_type', $type)->latest()->take(4)->get()->toArray();
    } else {
        $post = $query->where('post_type', $type)->orderBy('id', 'DESC')->get()->toArray();
    }

    if (count($post) > 0) {
        $order_data = manage_all_posts($post);
    }

    return $order_data;
}

function manage_all_posts($get_order){
    $order_data = array();

    if (count($get_order) > 0) {
        foreach ($get_order as $order) {
            $order_postmeta           = array();
            $get_postmeta_by_order_id = PostExtra::where(['post_id' => $order['id']])->get();
            $date_format = new Carbon($order['created_at']);
            $order_postmeta = $order;
            $order_postmeta['_date'] = $date_format->toDayDateTimeString();

            if ($get_postmeta_by_order_id->count() > 0) {
                foreach ($get_postmeta_by_order_id as $postmeta_row) {
                    $order_postmeta[$postmeta_row->key_name] = $postmeta_row->key_value;
                }
            }

            array_push($order_data, $order_postmeta);
        }
    }

    return $order_data;
}


/**
 * Create a slug from title
 * @param  string $title
 * @return string $slug
 */
function createSlug(string $title): string{
    $slugsFound = getSlugs($title);
    $counter = 0;
    $counter += $slugsFound;

    // $slug = str_slug($title, $separator = "-", app()->getLocale());
    $slug = Str::slug($title, $separator = "-", app()->getLocale());

    if ($counter) {
        $slug = $slug . '-' . $counter;
    }

    return $slug;
}

/**
 * Find same listing with same title
 * @param  string $title
 * @return int $total
 */
function getSlugs($title): int
{
    return Post::select()->where('post_title', 'like', $title)->count();
}


// Start function
function shorter($text, $chars_limit){
    if (strlen($text) > $chars_limit){
        $new_text = substr($text, 0, $chars_limit);
        $new_text = trim($new_text);
        return strip_tags($new_text) . "...";
    } else {
        return strip_tags($text) . "...";
    }
}


/**
* Create a post key and value
* @param sting, string
*
*/
function set_option_key_value($key, $value){
    try {
        $op = Option::where(['option_name' => $key])->first();
        if(empty($op)){
            $op = new Option;            
        }

        $op->option_name = $key;
        $op->option_value = $value;
        $op->save();

        return true;
    } catch (\Exception $e) {
        return false;
    }    
}


/**
 * Get post extra
 *
 * @param post_id, key_name
 * @return string
 */
function get_option_extra($key_name, $default = null){
    $data = $default;
    $get_post_extra = Option::where(['option_name' => $key_name])->first();
    if(!empty($get_post_extra)){
        $data = $get_post_extra->option_value;
    }
    
    return $data;
}

/**
 * Convert string in to array
 *
 * @param key_name
 * @return string
 */
function convert_string_to_array($string){
    if(!empty($string)){
        return explode(',', $string);
    }

    return [];
}


/**
 * Get the site title and logo
 *
 * @param key_name
 * @return string
 */
function get_site_title_logo(){
    if(!empty(get_option_extra('logo_path'))){
        return '<img src="'.asset('public').'/'.get_option_extra('logo_path').'" width="100">';
    } else {
        return get_option_extra('site_title') ?? config('app.name', 'Laravel');
    }
}

/**
 * Get the site title and logo
 *
 * @param key_name
 * @return string
 */
function get_site_title(){
    return get_option_extra('site_title') ?? config('app.name', 'Laravel');
}

/**
 * Get the site email
 *
 * @param key_name
 * @return string
 */
function get_site_email(){
    return get_option_extra('email') ?? 'admin@example.com';
}


/**
 * Get the footer menu
 *
 * @param key_name
 * @return string
 */
function get_footer_menu($menu_name){
    $menu = Menu::where('slug', $menu_name)->first();
    if(!empty($menu)){
        $nav = $menu->navbars;
        if(count($nav) > 0){
            $html = '';
            // dd($nav);
            foreach ($nav as $key => $value) {
                if (!isset($value->post->post_title)) {
                    continue;
                }

                $html .= '<a href="'.$value->route.'">'.$value->post->post_title.'</a>';
            }

            return $html;
        }
    }

    return '';
}


/**
 * Get the footer menu
 *
 * @param key_name
 * @return string
 */
function get_header_menu($menu_name){
    $menu = Menu::where('slug', $menu_name)->first();
    if(!empty($menu)){
        $nav = $menu->navbars;
        if(count($nav) > 0){
            $html = '';
            foreach ($nav as $key => $value) {
                if (!isset($value->post->post_title)) {
                    continue;
                }

                $sub_menu = Navbar::where('parent_id', $value->route_id)->get();
                if(count($sub_menu) > 0){
                    $html .= '<li class="drop-dwn-'.$key.'">';
                    $html .= '<a href="'.$value->route.'"class="drop-dwn me-sm-4">'.$value->post->post_title.'<i class="fa fa-angle-down"></i></a>';
                    $html .= '<ul class="submenu">';
                    foreach ($sub_menu as $val) {
                        if (!isset($val->post->post_title)) {
                            continue;
                        }
                        $html .= '<li><a href="'.$val->route.'">'.$val->post->post_title.'</a></li>';
                    }
                    $html .= '</ul>';
                    $html .= '</li>';
                } else {
                    $html .= '<li><a href="'.$value->route.'" class="nav-hide me-sm-4">'.$value->post->post_title.'</a></li>';
                }
            }

            return $html;
        }
    }

    return '';
}

function statusType(){
    return [
        '1' => 'Applied',
        '2' => 'Selected',
        '3' => 'Screening',
        '4' => 'Offered',
        '5' => 'Joining in Progress',
        '6' => 'Joined',
        '7' => 'Rejected',
        '8' => 'Completed',
    ];
}

function stageStatusType(){
    return [
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
    ];
}

function getStatusType($key = null){
    $status = statusType();
    if(!empty($key)){
        return $status[$key] ?? '';
    }

    return '';
}

function getStageStatusType($key = null){
    $status = stageStatusType();
    if(!empty($key)){
        return $status[$key] ?? '';
    }

    return '';
}

function countCV($job_id){
    return JobManageMent::where('job_id', $job_id)->whereNotNull('cv_path')->count();
}

function getScreening($job_id){
    return JobManageMent::where('job_id', $job_id)->where('status', 3)->count();
}

function getApply($job_id){
    return JobManageMent::where('job_id', $job_id)->where('status', 1)->count();
}

function getSelected($job_id){
    return JobManageMent::where('job_id', $job_id)->where('status', 2)->count();
}

function getRejected($job_id){
    return JobManageMent::where('job_id', $job_id)->where('status', 7)->count();
}

function getOffered($job_id){
    return JobManageMent::where('job_id', $job_id)->where('status', 4)->count();
}

function getJobByStatus($status_id){
    return JobManageMent::where('status', $status_id)->count();
}

function getTodayJob(){
    return JobManageMent::where('created_at', '>=', date('Y-m-d'))->count();
}

function getTotalUser(){
    return User::where('role_id', '3')->count();
}

function getUserExperince($user_id){
    return UserExperince::where('user_id', $user_id)->sum('exp_year');
}

if(! function_exists('randomPassword')){
    function randomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}

function getMailFormate(){
    return [
        'Employee Name', 'Employee Phone', 'Employee Email', 'Gender', 'Position For', 'Qualification', 'Experience in Year', 'Attached CV'
    ];
}

function employeeCompanyName($email){
    $contact = Contact::where('email', $email)->first();
    if(!empty($contact)){
        $contact->company->title ?? config('app.name', 'Laravel');
    }

    return get_option_extra('site_title') ?? config('app.name', 'Laravel');
}