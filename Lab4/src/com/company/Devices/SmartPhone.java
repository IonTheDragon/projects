package com.company.Devices;

import java.util.UUID;
public class SmartPhone extends Device{
    String sim;
    String simCount;
    public String GetDeviceType(){
        return "Smartphone";
    }
    public void create() {
        super.create();
        sim = "Sample Type";
        simCount = "1";
    }
    public void update(String m_count, String m_name, String m_price, String m_company, String m_model, String m_os, String m_sim, String m_simCount) {
        super.update(m_count, m_name, m_price, m_company, m_model, m_os);
        sim = m_sim;
        simCount = m_simCount;
    }
    public void read() {
        super.read();
        System.out.print("Тип SIM-карты ");
        System.out.println(sim);
        System.out.print("Количество SIM-карт ");
        System.out.println(simCount);
    }
    public void delete() {
        super.delete();
        sim = "";
        simCount = "";
    }
    public SmartPhone() {
        super();
        this.create();
    }
    public String GetParam1(){
        return sim;
    }
    public String GetParam2(){
        return simCount;
    }
    public SmartPhone(String m_count, String m_name, String m_price, String m_company, String m_model, String m_os, String m_sim, String m_simCount) {
        super();
        super.update(m_count, m_name, m_price, m_company, m_model, m_os);
        sim = m_sim;
        simCount = m_simCount;
    }
}