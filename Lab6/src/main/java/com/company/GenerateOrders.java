package com.company;

import com.company.Devices.*;

import java.util.*;

public class GenerateOrders{

    int ind;
    Order order;
    Credentials customers = new Credentials();
    ShoppingCart Cart0 = new ShoppingCart<Device>();
    ShoppingCart Cart1 = new ShoppingCart<Device>();
    ShoppingCart Cart2 = new ShoppingCart<Device>();
    ShoppingCart Cart3 = new ShoppingCart<Device>();
    ShoppingCart Cart4 = new ShoppingCart<Device>();
    ShoppingCart Cart5 = new ShoppingCart<Device>();

    Phone ph0 = new Phone("1","Хсяомя","2500","Джамшут дистрибутив","Хсяомя Хъ","Ведроид 1.5","Классический"," ");
    Phone ph1 = new Phone("2","Хсяомя","3500","Джамшут дистрибутив","Хсяомя Хэ","Ведроид 2.0","Классический"," ");
    SmartPhone sph1 = new SmartPhone("1","Унитазофон","25000","Индус-прошивка","Унитазофон 2018","Шишдовз визда","Обычная","2");
    Book bk1 = new Book("1","ПакетБука","33000","Гараж Васяна","Планшет 3000 элитный","Макось с таблэткой","Пенек","900х1200");
    Phone ph2 = new Phone("2","Бревнофон","300","Икея","Бревнофон 3000","Бревноид 1.1","Классический","резерв");
    SmartPhone sph2 = new SmartPhone("1","Унитазофон","24000","Индус-прошивка","Унитазофон 2017","Шишдовз визда","Обычная","1");
    Book bk2 = new Book("1","Доска деревянная","50","Димон инк","Доска 2018","Скоро будет","Доска на пеньке","900х1200");
    Phone ph3 = new Phone("3","Nokia","12000","Nokia","Nokia 4","Android","Классический","резерв");
    Book bk3 = new Book("2","NovaBook","55000","Green Gecko","Nova X","GeckOS","CycluraIntegral","900х1200");
    Phone ph4 = new Phone("5","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","резерв");
    Book bk4 = new Book("5","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО","СЕКРЕТНО");
    Phone ph5 = new Phone("1","МОНОЛИТ","350000","Циклура","УДАЛЕНО","УДАЛЕНО","Классический","резерв");
    SmartPhone sph5 = new SmartPhone("1","Артемида","600000","УДАЛЕНО","Артемида УДАЛЕНО","УДАЛЕНО","Обычная","УДАЛЕНО");
    Book bk5 = new Book("1","Прототип 33460","500000","Циклура","33460 2018","СЕКРЕТНО","СЕКРЕТНО","4000х4000");

    GenerateOrders(int m_ind) {
        customers.AddUser("Ashot","Galustyan","Vaganych","armen@mail.am");
        customers.AddUser("Stas","Hrenov","Petrovich","hrenoff@mail.ru");
        customers.AddUser("Katya","Iwanova","Petrovna","katya@gmail.com");
        customers.AddUser("Ivan","Voznyuk","Vyacheslavovich","ivan@stonejungle.org");
        customers.AddUser("Ivan","Hromov","Stepanovich","СЕКРЕТНО");
        customers.AddUser("Janna","Rasputin","Michailovna","janna@gmail.com");
        customers.AddUser("Ramzan","Vazgenka","Michailovna","ramzanzanzan@ya.ru");
        this.ind = m_ind;
    }

    public void Generate() {
        if (ind == 1) {
            Cart1.add(ph1);
            Cart1.add(sph1);
            Cart1.add(bk1);
            this.order = new Order(Cart1,customers,0);
        }
        else if (ind == 2) {
            Cart2.add(ph2);
            Cart2.add(sph2);
            Cart2.add(bk2);
            this.order = new Order(Cart2,customers,1);
        }
        else if (ind == 3) {
            Cart3.add(ph3);
            Cart3.add(bk3);
            this.order = new Order(Cart3,customers,2);
        }
        else if (ind == 4) {
            Cart4.add(ph4);
            Cart4.add(bk4);
            this.order = new Order(Cart4,customers,3);
        }
        else if (ind == 4) {
            Cart5.add(ph5);
            Cart5.add(sph5);
            Cart5.add(bk5);
            this.order = new Order(Cart5,customers,4);
        }
    }

    public Order InitOrder() {
        Cart0.add(ph0);
        Order m_order = new Order(Cart0,customers,5);
        return m_order;
    }

}

