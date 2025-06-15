package com.example.projectkape

import android.content.Intent
import android.net.Uri
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import androidx.recyclerview.widget.RecyclerView

class VlogAdapter(
    private var vlogList: List<CardItem>
) : RecyclerView.Adapter<VlogAdapter.VlogViewHolder>() {

    inner class VlogViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView)

    override fun onCreateViewHolder(parent: ViewGroup, viewType: Int): VlogViewHolder {
        val view = LayoutInflater.from(parent.context)
            .inflate(R.layout.item_vlog, parent, false)
        return VlogViewHolder(view)
    }

    override fun onBindViewHolder(holder: VlogViewHolder, position: Int) {
        val item = vlogList[position]

        holder.itemView.setOnClickListener {
            val context = holder.itemView.context
            val intent = Intent(Intent.ACTION_VIEW, Uri.parse(item.youtubeUrl))
            intent.setPackage("com.google.android.youtube") // Optional: force YouTube app
            context.startActivity(intent)
        }
    }

    override fun getItemCount(): Int = vlogList.size

    fun updateList(newList: List<CardItem>) {
        vlogList = newList
        notifyDataSetChanged()
    }
}
