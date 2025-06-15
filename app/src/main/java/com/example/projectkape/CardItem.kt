package com.example.projectkape

data class CardItem(
    val title: String,
    val description: String,
    val imageResId: Int,
    val tagLabel: String,
    val youtubeUrl: String? = null )
