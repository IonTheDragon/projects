import java.util.ArrayList;
import java.util.UUID;
public class ShoppingCart{
 ArrayList<Item> ShoppingCartList = new ArrayList<>();
 public void add(UUID m_id, String m_goods) {
	ShoppingCartList.add(new Item(m_id, m_goods));
 }
 public void delete(UUID m_id) { 
	ShoppingCartList.remove(m_id);
 } 
 public void show() {	
	for (int i = 0; i < ShoppingCartList.size(); i++) {
		System.out.println(ShoppingCartList.get(i));
	}
 }
}
