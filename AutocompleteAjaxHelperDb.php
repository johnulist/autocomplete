<?php
class AutocompleteAjaxHelperDb
{
    public function getProductsAutocomplete($query, $excludeIds)
    {
        $query = pSQL($query);
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;

        $sql = new DbQuery();
        $sql->select('p.id_product, pl.name');
        $sql->from('product', 'p');
        $sql->innerJoin('product_lang', 'pl', 'p.id_product = pl.id_product');
        $sql->where('pl.id_lang = '.(int)$langId);
        $sql->where('pl.id_shop = '.(int)$shopId);
        $sql->where('pl.name LIKE "%'.$query.'%"');
        $sql->where('p.active = 1');
        !empty($excludeIds)?  $sql->where('p.id_product NOT IN ('.$excludeIds.')') : '';
        return Db::getInstance()->executeS($sql);
    }

    public function getCategoriesAutocomplete($query, $excludeIds)
    {
        $query = pSQL($query);
        $langId = Context::getContext()->language->id;
        $shopId = Context::getContext()->shop->id;

        $sql = new DbQuery();
        $sql->select('c.id_category, cl.name');
        $sql->from('category', 'c');
        $sql->innerJoin('category_lang', 'cl', 'c.id_category = cl.id_category');
        $sql->where('cl.id_lang = '.(int)$langId);
        $sql->where('cl.id_shop = '.(int)$shopId);
        $sql->where('cl.name LIKE "%'.$query.'%"');
        $sql->where('c.active = 1');
        $sql->where('c.id_category > 2');
        !empty($excludeIds)?  $sql->where('c.id_category NOT IN ('.$excludeIds.')') : '';
        return Db::getInstance()->executeS($sql);
    }
}
