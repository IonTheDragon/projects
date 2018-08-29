package com.company.Devices;

import java.util.UUID;
public class Phone extends Device{
    String type;
    public String GetDeviceType(){
        return "Phone";
    }
    public void create() {
        super.create();
        type = "Sample Type";
    }
    public void update(String m_count, String m_name, String m_price, String m_company, String m_model, String m_os, String m_type, String m_arg) {
        super.update(m_count, m_name, m_price, m_company, m_model, m_os);
        type = m_type;
    }
    public void read() {
        super.read();
        System.out.print("Тип корпуса ");
        System.out.println(type);
    }
    public void delete() {
        super.delete();
        type = "";
    }

    public String GetParam1(){
        return type;
    }
    public Phone(String m_count, String m_name, String m_price, String m_company, String m_model, String m_os, String m_type, String m_arg) {
        super();
        super.update(m_count, m_name, m_price, m_company, m_model, m_os);
        type = m_type;
        param2 = m_arg;
    }
}
