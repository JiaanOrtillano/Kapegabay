import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import androidx.recyclerview.widget.RecyclerView
import com.example.projectkape.CardItem
import com.example.projectkape.R

class CardAdapter(private val itemList: List<CardItem>) : RecyclerView.Adapter<CardAdapter.CardViewHolder>() {

    inner class CardViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val title: TextView = itemView.findViewById(R.id.title)
        val description: TextView = itemView.findViewById(R.id.description)
        val thumbnail: ImageView = itemView.findViewById(R.id.thumbnail)
        val tagButton: Button = itemView.findViewById(R.id.tagButton)
    }

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): CardViewHolder {
        val view = LayoutInflater.from(parent.context).inflate(R.layout.item_card, parent, false)
        return CardViewHolder(view)
    }

    override fun onBindViewHolder(holder: CardViewHolder, position: Int) {
        val item = itemList[position]
        holder.title.text = item.title
        holder.description.text = item.description
        holder.thumbnail.setImageResource(item.imageResId) // For URL, use Glide/Picasso
        holder.tagButton.text = item.tagLabel
    }

    override fun getItemCount(): Int = itemList.size
}
