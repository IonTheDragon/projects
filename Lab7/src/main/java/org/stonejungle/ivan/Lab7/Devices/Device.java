package org.stonejungle.ivan.Lab7.Devices;

import java.io.Serializable;
import java.util.UUID;

abstract public class Device implements ICrudAction, Serializable {
    public UUID id;
    public String name;
    public String price;
    public String count;
    public String company;
    public String model;
    public String os;
    public String deviceType = "Undefined";
    public transient String param1;
    public transient String param2;

    public Device(String m_count, String m_name, String m_price, String m_company, String m_model, String m_os, String m_arg, String m_arg2){
        id = UUID.randomUUID();
        this.update(m_count, m_name, m_price, m_company, m_model, m_os);
        param1 = m_arg;
        param2 = m_arg2;
    }
    public Device(){
        id = UUID.randomUUID();
        this.update("", "", "", "", "", "");
        param1 = "";
        param2 = "";
    }

    public String GetName(){
        return name;
    }
    public String GetPrice(){
        return price;
    }
    public String GetCompany(){
        return company;
    }
    public String GetModel(){
        return model;
    }
    public String GetOs(){
        return os;
    }
    public String GetCount(){
        return count;
    }
    public UUID GetId(){
        return id;
    }
    public String GetDeviceType(){
        return deviceType;
    }
    public String GetParam1(){
        return param1;
    }
    public String GetParam2(){
        return param2;
    }
    public void create() {
        count = "1";
        name = "Sample name";
        price = "10000";
        company = "Sample company";
        model = "Sample model";
        os = "Sample OS";
        param1 = "Частный параметр 1";
        param2 = "Частный параметр 2";
    }
    public void read() {
        System.out.print("ID ");
        System.out.println(id);
        System.out.print("№ объекта ");
        System.out.println(count);
        System.out.print("Название ");
        System.out.println(name);
        System.out.print("Цена ");
        System.out.println(price);
        System.out.print("Изготовитель ");
        System.out.println(company);
        System.out.print("Модель ");
        System.out.println(model);
        System.out.print("Платформа ");
        System.out.println(os);
    }
    public void update(String m_count, String m_name, String m_price, String m_company, String m_model, String m_os) {
        name = m_name;
        price = m_price;
        company = m_company;
        model = m_model;
        os = m_os;
        count = m_count;
    }
    public void delete() {
        name = "";
        price = "";
        company = "";
        model = "";
        os = "";
        count = "";
    }
}