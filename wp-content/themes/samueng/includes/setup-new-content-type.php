
<?php
//Custom Post Setup
class Setup_New_Content_Type
{
    public function __construct() 
    {
        // add_action('init', [$this, 'create_project_type_taxonomy']);
        add_action('init', [$this, 'create_genres_taxonomy']);
        add_action('init', [$this, 'create_projects_post_type']);
        add_action('init', [$this, 'add_project_taxonomies']);
    }


    #region // ------------------- Add new Taxonomies ------------------------
        
        // Tạo custom taxonomy cho Project Type
        // function create_project_type_taxonomy() {
        //     register_taxonomy(
        //         'project_type', // Tên của taxonomy
        //         'post', // Loại nội dung mà taxonomy này áp dụng (có thể là 'post', 'page' hoặc loại post tùy chỉnh khác)
        //         array(
        //             'hierarchical' => true, // Cho phép phân loại có cấu trúc phân cấp (giống category)
        //             'label' => 'Project Types',
        //             'show_ui' => true, // Hiển thị giao diện người dùng trong WordPress admin
        //             'show_admin_column' => true, // Hiển thị cột trong phần quản lý bài viết
        //             'query_var' => true,
        //             'rewrite' => array(
        //                 'slug' => 'project-type', // Đường dẫn URL của taxonomy này
        //                 'with_front' => false
        //             ),
        //         )
        //     );
        // }

        // Tạo custom taxonomy cho Genres
        function create_genres_taxonomy() {
            register_taxonomy(
                'genres', // Tên của taxonomy
                'post', // Loại nội dung áp dụng
                array(
                    'hierarchical' => true, // Cấu trúc phân cấp
                    'label' => 'Genres',
                    'show_ui' => true,
                    'show_admin_column' => true,
                    'query_var' => true,
                    'rewrite' => array(
                        'slug' => 'genres',
                        'with_front' => false
                    ),
                )
            );
        }
    #endregion

    #region // ------------------- Add new Post ------------------------
        
        // Tạo Custom Post Type cho Projects
        public function create_projects_post_type() {
            $args = array(
                'labels' => array(
                    'name' => 'Projects',
                    'singular_name' => 'Project',
                    'add_new' => 'Add New',
                    'add_new_item' => 'Add New Project',
                    'edit_item' => 'Edit Project',
                    'new_item' => 'New Project',
                    'view_item' => 'View Project',
                    'search_items' => 'Search Projects',
                    'not_found' => 'No Projects found',
                    'not_found_in_trash' => 'No Projects found in Trash',
                    'all_items' => 'All Projects',
                    'menu_name' => 'Projects',
                    'name_admin_bar' => 'Project'
                ),
                'public' => true, // Chỉ định loại nội dung này là công khai
                'hierarchical' => true, // Cho phép phân cấp nếu bạn muốn, giống như Pages (false nếu giống Posts)
                'menu_position' => 5, // Vị trí trong admin menu
                'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments'), // Những tính năng hỗ trợ
                'has_archive' => true, // Bật tính năng archive cho Custom Post Type
                'rewrite' => array(
                    'slug' => 'projects',  // Đặt "projects" là slug cho URL
                    'with_front' => false, // Đảm bảo không sử dụng phần trước URL (như "wordpress")
                ),
                'show_in_rest' => true, // Bật REST API cho CPT (quan trọng nếu bạn sử dụng block editor)
            );
            register_post_type('projects', $args); // Đăng ký Custom Post Type
        }
    
    #endregion

    #region // ------------------- Register Taxonomies to new Post ------------------------

        function add_project_taxonomies() {
            // Gán taxonomy Project Type cho CPT Projects
            // register_taxonomy_for_object_type('project_type', 'projects');
            // Gán taxonomy Genres cho CPT Projects
            register_taxonomy_for_object_type('genres', 'projects');
        }
    #endregion
}
?>