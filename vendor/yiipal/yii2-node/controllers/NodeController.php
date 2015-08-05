<?php
namespace yiipal\node\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yiipal\base\controllers\BaseController;
use yiipal\cck\models\FieldModel;
use yiipal\node\models\Node;
/**
 * Book controller
 */
class NodeController extends BaseController
{
    public function init(){
        parent::init();
        $this->session->set('nodeType', $this->arg(0));
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [];
    }

    public function actionList(){
//        $str = 'a:13:{s:4:"uuid";s:36:"11868ba9-79b8-4747-ac00-ec0d6d36b1a6";s:8:"langcode";s:2:"en";s:6:"status";b:1;s:12:"dependencies";a:1:{s:6:"module";a:2:{i:0;s:4:"node";i:1;s:4:"user";}}s:2:"id";s:7:"content";s:5:"label";s:7:"Content";s:6:"module";s:4:"node";s:11:"description";s:24:"Find and manage content.";s:3:"tag";s:7:"default";s:10:"base_table";s:15:"node_field_data";s:10:"base_field";s:3:"nid";s:4:"core";s:3:"8.x";s:7:"display";a:2:{s:7:"default";a:6:{s:15:"display_options";a:17:{s:6:"access";a:2:{s:4:"type";s:4:"perm";s:7:"options";a:1:{s:4:"perm";s:23:"access content overview";}}s:5:"cache";a:1:{s:4:"type";s:4:"none";}s:5:"query";a:1:{s:4:"type";s:11:"views_query";}s:12:"exposed_form";a:2:{s:4:"type";s:5:"basic";s:7:"options";a:7:{s:13:"submit_button";s:6:"Filter";s:12:"reset_button";b:1;s:18:"reset_button_label";s:5:"Reset";s:19:"exposed_sorts_label";s:7:"Sort by";s:17:"expose_sort_order";b:1;s:14:"sort_asc_label";s:3:"Asc";s:15:"sort_desc_label";s:4:"Desc";}}s:5:"pager";a:2:{s:4:"type";s:4:"full";s:7:"options";a:2:{s:14:"items_per_page";i:50;s:4:"tags";a:4:{s:8:"previous";s:12:"‹ previous";s:4:"next";s:8:"next ›";s:5:"first";s:8:"« first";s:4:"last";s:7:"last »";}}}s:5:"style";a:2:{s:4:"type";s:5:"table";s:7:"options";a:12:{s:8:"grouping";a:0:{}s:9:"row_class";s:0:"";s:17:"default_row_class";b:1;s:8:"override";b:1;s:6:"sticky";b:1;s:7:"caption";s:0:"";s:7:"summary";s:0:"";s:11:"description";s:0:"";s:7:"columns";a:10:{s:14:"node_bulk_form";s:14:"node_bulk_form";s:5:"title";s:5:"title";s:4:"type";s:4:"type";s:4:"name";s:4:"name";s:6:"status";s:6:"status";s:7:"changed";s:7:"changed";s:9:"edit_node";s:9:"edit_node";s:11:"delete_node";s:11:"delete_node";s:10:"dropbutton";s:10:"dropbutton";s:9:"timestamp";s:5:"title";}s:4:"info";a:10:{s:14:"node_bulk_form";a:4:{s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}s:5:"title";a:6:{s:8:"sortable";b:1;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}s:4:"type";a:6:{s:8:"sortable";b:1;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}s:4:"name";a:6:{s:8:"sortable";b:0;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:12:"priority-low";}s:6:"status";a:6:{s:8:"sortable";b:1;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}s:7:"changed";a:6:{s:8:"sortable";b:1;s:18:"default_sort_order";s:4:"desc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:12:"priority-low";}s:9:"edit_node";a:6:{s:8:"sortable";b:0;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}s:11:"delete_node";a:6:{s:8:"sortable";b:0;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}s:10:"dropbutton";a:6:{s:8:"sortable";b:0;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}s:9:"timestamp";a:6:{s:8:"sortable";b:0;s:18:"default_sort_order";s:3:"asc";s:5:"align";s:0:"";s:9:"separator";s:0:"";s:12:"empty_column";b:0;s:10:"responsive";s:0:"";}}s:7:"default";s:7:"changed";s:11:"empty_table";b:1;}}s:3:"row";a:1:{s:4:"type";s:6:"fields";}s:6:"fields";a:7:{s:14:"node_bulk_form";a:14:{s:2:"id";s:14:"node_bulk_form";s:5:"table";s:4:"node";s:5:"field";s:14:"node_bulk_form";s:5:"label";s:0:"";s:7:"exclude";b:0;s:5:"alter";a:1:{s:10:"alter_text";b:0;}s:13:"element_class";s:0:"";s:23:"element_default_classes";b:1;s:5:"empty";s:0:"";s:10:"hide_empty";b:0;s:10:"empty_zero";b:0;s:16:"hide_alter_empty";b:1;s:9:"plugin_id";s:14:"node_bulk_form";s:11:"entity_type";s:4:"node";}s:5:"title";a:17:{s:2:"id";s:5:"title";s:5:"table";s:15:"node_field_data";s:5:"field";s:5:"title";s:5:"label";s:5:"Title";s:7:"exclude";b:0;s:5:"alter";a:1:{s:10:"alter_text";b:0;}s:13:"element_class";s:0:"";s:23:"element_default_classes";b:1;s:5:"empty";s:0:"";s:10:"hide_empty";b:0;s:10:"empty_zero";b:0;s:16:"hide_alter_empty";b:1;s:11:"entity_type";s:4:"node";s:12:"entity_field";s:5:"title";s:4:"type";s:6:"string";s:8:"settings";a:1:{s:14:"link_to_entity";b:1;}s:9:"plugin_id";s:5:"field";}s:4:"type";a:37:{s:2:"id";s:4:"type";s:5:"table";s:15:"node_field_data";s:5:"field";s:4:"type";s:12:"relationship";s:4:"none";s:10:"group_type";s:5:"group";s:11:"admin_label";s:0:"";s:5:"label";s:12:"Content Type";s:7:"exclude";b:0;s:5:"alter";a:26:{s:10:"alter_text";b:0;s:4:"text";s:0:"";s:9:"make_link";b:0;s:4:"path";s:0:"";s:8:"absolute";b:0;s:8:"external";b:0;s:14:"replace_spaces";b:0;s:9:"path_case";s:4:"none";s:15:"trim_whitespace";b:0;s:3:"alt";s:0:"";s:3:"rel";s:0:"";s:10:"link_class";s:0:"";s:6:"prefix";s:0:"";s:6:"suffix";s:0:"";s:6:"target";s:0:"";s:5:"nl2br";b:0;s:10:"max_length";i:0;s:13:"word_boundary";b:1;s:8:"ellipsis";b:1;s:9:"more_link";b:0;s:14:"more_link_text";s:0:"";s:14:"more_link_path";s:0:"";s:10:"strip_tags";b:0;s:4:"trim";b:0;s:13:"preserve_tags";s:0:"";s:4:"html";b:0;}s:12:"element_type";s:0:"";s:13:"element_class";s:0:"";s:18:"element_label_type";s:0:"";s:19:"element_label_class";s:0:"";s:19:"element_label_colon";b:1;s:20:"element_wrapper_type";s:0:"";s:21:"element_wrapper_class";s:0:"";s:23:"element_default_classes";b:1;s:5:"empty";s:0:"";s:10:"hide_empty";b:0;s:10:"empty_zero";b:0;s:16:"hide_alter_empty";b:1;s:17:"click_sort_column";s:9:"target_id";s:4:"type";s:22:"entity_reference_label";s:8:"settings";a:1:{s:4:"link";b:0;}s:12:"group_column";s:9:"target_id";s:13:"group_columns";a:0:{}s:10:"group_rows";b:1;s:11:"delta_limit";i:0;s:12:"delta_offset";i:0;s:14:"delta_reversed";b:0;s:16:"delta_first_last";b:0;s:10:"multi_type";s:9:"separator";s:9:"separator";s:2:", ";s:17:"field_api_classes";b:0;s:11:"entity_type";s:4:"node";s:12:"entity_field";s:4:"type";s:9:"plugin_id";s:5:"field";}s:4:"name";a:17:{s:2:"id";s:4:"name";s:5:"table";s:16:"users_field_data";s:5:"field";s:4:"name";s:12:"relationship";s:3:"uid";s:5:"label";s:6:"Author";s:7:"exclude";b:0;s:5:"alter";a:1:{s:10:"alter_text";b:0;}s:13:"element_class";s:0:"";s:23:"element_default_classes";b:1;s:5:"empty";s:0:"";s:10:"hide_empty";b:0;s:10:"empty_zero";b:0;s:16:"hide_alter_empty";b:1;s:9:"plugin_id";s:5:"field";s:4:"type";s:9:"user_name";s:11:"entity_type";s:4:"user";s:12:"entity_field";s:4:"name";}s:6:"status";a:17:{s:2:"id";s:6:"status";s:5:"table";s:15:"node_field_data";s:5:"field";s:6:"status";s:5:"label";s:6:"Status";s:7:"exclude";b:0;s:5:"alter";a:1:{s:10:"alter_text";b:0;}s:13:"element_class";s:0:"";s:23:"element_default_classes";b:1;s:5:"empty";s:0:"";s:10:"hide_empty";b:0;s:10:"empty_zero";b:0;s:16:"hide_alter_empty";b:1;s:4:"type";s:7:"boolean";s:8:"settings";a:3:{s:6:"format";s:6:"custom";s:18:"format_custom_true";s:9:"Published";s:19:"format_custom_false";s:11:"Unpublished";}s:9:"plugin_id";s:5:"field";s:11:"entity_type";s:4:"node";s:12:"entity_field";s:6:"status";}s:7:"changed";a:18:{s:2:"id";s:7:"changed";s:5:"table";s:15:"node_field_data";s:5:"field";s:7:"changed";s:5:"label";s:7:"Updated";s:7:"exclude";b:0;s:5:"alter";a:1:{s:10:"alter_text";b:0;}s:13:"element_class";s:0:"";s:23:"element_default_classes";b:1;s:5:"empty";s:0:"";s:10:"hide_empty";b:0;s:10:"empty_zero";b:0;s:16:"hide_alter_empty";b:1;s:11:"date_format";s:5:"short";s:18:"custom_date_format";s:0:"";s:8:"timezone";s:0:"";s:9:"plugin_id";s:4:"date";s:11:"entity_type";s:4:"node";s:12:"entity_field";s:7:"changed";}s:10:"operations";a:23:{s:2:"id";s:10:"operations";s:5:"table";s:4:"node";s:5:"field";s:10:"operations";s:12:"relationship";s:4:"none";s:10:"group_type";s:5:"group";s:11:"admin_label";s:0:"";s:5:"label";s:10:"Operations";s:7:"exclude";b:0;s:5:"alter";a:26:{s:10:"alter_text";b:0;s:4:"text";s:0:"";s:9:"make_link";b:0;s:4:"path";s:0:"";s:8:"absolute";b:0;s:8:"external";b:0;s:14:"replace_spaces";b:0;s:9:"path_case";s:4:"none";s:15:"trim_whitespace";b:0;s:3:"alt";s:0:"";s:3:"rel";s:0:"";s:10:"link_class";s:0:"";s:6:"prefix";s:0:"";s:6:"suffix";s:0:"";s:6:"target";s:0:"";s:5:"nl2br";b:0;s:10:"max_length";i:0;s:13:"word_boundary";b:1;s:8:"ellipsis";b:1;s:9:"more_link";b:0;s:14:"more_link_text";s:0:"";s:14:"more_link_path";s:0:"";s:10:"strip_tags";b:0;s:4:"trim";b:0;s:13:"preserve_tags";s:0:"";s:4:"html";b:0;}s:12:"element_type";s:0:"";s:13:"element_class";s:0:"";s:18:"element_label_type";s:0:"";s:19:"element_label_class";s:0:"";s:19:"element_label_colon";b:1;s:20:"element_wrapper_type";s:0:"";s:21:"element_wrapper_class";s:0:"";s:23:"element_default_classes";b:1;s:5:"empty";s:0:"";s:10:"hide_empty";b:0;s:10:"empty_zero";b:0;s:16:"hide_alter_empty";b:1;s:11:"destination";b:1;s:9:"plugin_id";s:17:"entity_operations";}}s:7:"filters";a:5:{s:12:"status_extra";a:8:{s:2:"id";s:12:"status_extra";s:5:"table";s:15:"node_field_data";s:5:"field";s:12:"status_extra";s:8:"operator";s:1:"=";s:5:"value";b:0;s:9:"plugin_id";s:11:"node_status";s:5:"group";i:1;s:11:"entity_type";s:4:"node";}s:6:"status";a:16:{s:2:"id";s:6:"status";s:5:"table";s:15:"node_field_data";s:5:"field";s:6:"status";s:12:"relationship";s:4:"none";s:10:"group_type";s:5:"group";s:11:"admin_label";s:0:"";s:8:"operator";s:1:"=";s:5:"value";b:1;s:5:"group";i:1;s:7:"exposed";b:1;s:6:"expose";a:10:{s:11:"operator_id";s:0:"";s:5:"label";s:6:"Status";s:11:"description";s:0:"";s:12:"use_operator";b:0;s:8:"operator";s:9:"status_op";s:10:"identifier";s:6:"status";s:8:"required";b:0;s:8:"remember";b:0;s:8:"multiple";b:0;s:14:"remember_roles";a:1:{s:13:"authenticated";s:13:"authenticated";}}s:10:"is_grouped";b:1;s:10:"group_info";a:10:{s:5:"label";s:16:"Published status";s:11:"description";s:0:"";s:10:"identifier";s:6:"status";s:8:"optional";b:1;s:6:"widget";s:6:"select";s:8:"multiple";b:0;s:8:"remember";b:0;s:13:"default_group";s:3:"All";s:22:"default_group_multiple";a:0:{}s:11:"group_items";a:2:{i:1;a:3:{s:5:"title";s:9:"Published";s:8:"operator";s:1:"=";s:5:"value";s:1:"1";}i:2;a:3:{s:5:"title";s:11:"Unpublished";s:8:"operator";s:1:"=";s:5:"value";s:1:"0";}}}s:9:"plugin_id";s:7:"boolean";s:11:"entity_type";s:4:"node";s:12:"entity_field";s:6:"status";}s:4:"type";a:16:{s:2:"id";s:4:"type";s:5:"table";s:15:"node_field_data";s:5:"field";s:4:"type";s:12:"relationship";s:4:"none";s:10:"group_type";s:5:"group";s:11:"admin_label";s:0:"";s:8:"operator";s:2:"in";s:5:"value";a:0:{}s:5:"group";i:1;s:7:"exposed";b:1;s:6:"expose";a:11:{s:11:"operator_id";s:7:"type_op";s:5:"label";s:4:"Type";s:11:"description";s:0:"";s:12:"use_operator";b:0;s:8:"operator";s:7:"type_op";s:10:"identifier";s:4:"type";s:8:"required";b:0;s:8:"remember";b:0;s:8:"multiple";b:0;s:14:"remember_roles";a:3:{s:13:"authenticated";s:13:"authenticated";s:9:"anonymous";s:1:"0";s:13:"administrator";s:1:"0";}s:6:"reduce";b:0;}s:10:"is_grouped";b:0;s:10:"group_info";a:10:{s:5:"label";s:0:"";s:11:"description";s:0:"";s:10:"identifier";s:0:"";s:8:"optional";b:1;s:6:"widget";s:6:"select";s:8:"multiple";b:0;s:8:"remember";b:0;s:13:"default_group";s:3:"All";s:22:"default_group_multiple";a:0:{}s:11:"group_items";a:0:{}}s:9:"plugin_id";s:6:"bundle";s:11:"entity_type";s:4:"node";s:12:"entity_field";s:4:"type";}s:5:"title";a:16:{s:2:"id";s:5:"title";s:5:"table";s:15:"node_field_data";s:5:"field";s:5:"title";s:12:"relationship";s:4:"none";s:10:"group_type";s:5:"group";s:11:"admin_label";s:0:"";s:8:"operator";s:8:"contains";s:5:"value";s:0:"";s:5:"group";i:1;s:7:"exposed";b:1;s:6:"expose";a:10:{s:11:"operator_id";s:8:"title_op";s:5:"label";s:5:"Title";s:11:"description";s:0:"";s:12:"use_operator";b:0;s:8:"operator";s:8:"title_op";s:10:"identifier";s:5:"title";s:8:"required";b:0;s:8:"remember";b:0;s:8:"multiple";b:0;s:14:"remember_roles";a:3:{s:13:"authenticated";s:13:"authenticated";s:9:"anonymous";s:1:"0";s:13:"administrator";s:1:"0";}}s:10:"is_grouped";b:0;s:10:"group_info";a:10:{s:5:"label";s:0:"";s:11:"description";s:0:"";s:10:"identifier";s:0:"";s:8:"optional";b:1;s:6:"widget";s:6:"select";s:8:"multiple";b:0;s:8:"remember";b:0;s:13:"default_group";s:3:"All";s:22:"default_group_multiple";a:0:{}s:11:"group_items";a:0:{}}s:9:"plugin_id";s:6:"string";s:11:"entity_type";s:4:"node";s:12:"entity_field";s:5:"title";}s:8:"langcode";a:16:{s:2:"id";s:8:"langcode";s:5:"table";s:15:"node_field_data";s:5:"field";s:8:"langcode";s:12:"relationship";s:4:"none";s:10:"group_type";s:5:"group";s:11:"admin_label";s:0:"";s:8:"operator";s:2:"in";s:5:"value";a:0:{}s:5:"group";i:1;s:7:"exposed";b:1;s:6:"expose";a:11:{s:11:"operator_id";s:11:"langcode_op";s:5:"label";s:8:"Language";s:11:"description";s:0:"";s:12:"use_operator";b:0;s:8:"operator";s:11:"langcode_op";s:10:"identifier";s:8:"langcode";s:8:"required";b:0;s:8:"remember";b:0;s:8:"multiple";b:0;s:14:"remember_roles";a:3:{s:13:"authenticated";s:13:"authenticated";s:9:"anonymous";s:1:"0";s:13:"administrator";s:1:"0";}s:6:"reduce";b:0;}s:10:"is_grouped";b:0;s:10:"group_info";a:10:{s:5:"label";s:0:"";s:11:"description";s:0:"";s:10:"identifier";s:0:"";s:8:"optional";b:1;s:6:"widget";s:6:"select";s:8:"multiple";b:0;s:8:"remember";b:0;s:13:"default_group";s:3:"All";s:22:"default_group_multiple";a:0:{}s:11:"group_items";a:0:{}}s:9:"plugin_id";s:8:"language";s:11:"entity_type";s:4:"node";s:12:"entity_field";s:8:"langcode";}}s:5:"sorts";a:0:{}s:5:"title";s:7:"Content";s:5:"empty";a:1:{s:16:"area_text_custom";a:6:{s:2:"id";s:16:"area_text_custom";s:5:"table";s:5:"views";s:5:"field";s:16:"area_text_custom";s:5:"empty";b:1;s:7:"content";s:21:"No content available.";s:9:"plugin_id";s:11:"text_custom";}}s:9:"arguments";a:0:{}s:13:"relationships";a:1:{s:3:"uid";a:6:{s:2:"id";s:3:"uid";s:5:"table";s:15:"node_field_data";s:5:"field";s:3:"uid";s:11:"admin_label";s:6:"author";s:8:"required";b:1;s:9:"plugin_id";s:8:"standard";}}s:16:"show_admin_links";b:0;s:13:"filter_groups";a:2:{s:8:"operator";s:3:"AND";s:6:"groups";a:1:{i:1;s:3:"AND";}}s:17:"display_extenders";a:0:{}}s:14:"display_plugin";s:7:"default";s:13:"display_title";s:6:"Master";s:2:"id";s:7:"default";s:8:"position";i:0;s:14:"cache_metadata";a:2:{s:8:"contexts";a:5:{i:0;s:26:"languages:language_content";i:1;s:28:"languages:language_interface";i:2;s:3:"url";i:3;s:4:"user";i:4;s:21:"user.node_grants:view";}s:9:"cacheable";b:0;}}s:6:"page_1";a:6:{s:15:"display_options";a:4:{s:4:"path";s:18:"admin/content/node";s:4:"menu";a:6:{s:4:"type";s:11:"default tab";s:5:"title";s:7:"Content";s:11:"description";s:0:"";s:9:"menu_name";s:5:"admin";s:6:"weight";i:-10;s:7:"context";s:0:"";}s:11:"tab_options";a:5:{s:4:"type";s:6:"normal";s:5:"title";s:7:"Content";s:11:"description";s:23:"Find and manage content";s:9:"menu_name";s:5:"admin";s:6:"weight";i:-10;}s:17:"display_extenders";a:0:{}}s:14:"display_plugin";s:4:"page";s:13:"display_title";s:4:"Page";s:2:"id";s:6:"page_1";s:8:"position";i:1;s:14:"cache_metadata";a:2:{s:8:"contexts";a:5:{i:0;s:26:"languages:language_content";i:1;s:28:"languages:language_interface";i:2;s:3:"url";i:3;s:4:"user";i:4;s:21:"user.node_grants:view";}s:9:"cacheable";b:0;}}}}';
//        $str = unserialize($str);
//        print_r($str);exit;
        $type = $this->arg(0);
        $dataProvider = new ActiveDataProvider([
            'query' => Node::findQuery($type),
            'pagination' => [
                'pageSize' => 10,
                'route' => Yii::$app->request->getPathInfo(),
            ],
            'sort' => [
                'defaultOrder' => [
                    //'nid' => SORT_ASC,
                    //'company' => SORT_ASC,
                ]
            ],
        ]);
        //$dataProvider->getModels();
        return $this->render('@yiipal/node/views/node/index', [
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionUpdate()
    {
        $nodeType = $this->arg(0);
        $id = Yii::$app->request->get('id');
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/node/list/'.$nodeType]);
        } else {
            return $this->render('@yiipal/node/views/node/update', [
                'model' => $model,
            ]);
        }
        return $this->render('update');
    }

    public function actionCreate()
    {
        $nodeType = $this->arg(0);
        //FIXME:检查类型是否存在
        if(empty($nodeType)){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model = new Node($nodeType);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/node/list/'.$nodeType]);
        } else {
            return $this->render('@yiipal/node/views/node/update', [
                'model' => $model,
            ]);
        }
        return $this->render('update');
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $nodeType = $this->arg(0);
        $fields = FieldModel::findAll(['collection'=>"field.node.$nodeType"]);
        foreach($fields as $field){
            $fieldClass = $field->data_field_class;
            $fieldClass::$tableName = $field->name;
            $fieldModel = $fieldClass::findOne(['nid'=>$id]);
            if($fieldModel){
                $fieldModel->delete();
            }
        }
        $this->findModel($id)->delete();
        return $this->redirect(['/node/list/'.$nodeType]);
    }
}
