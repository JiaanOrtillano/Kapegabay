package com.example.projectkape

data class CardItem(
    val title: String,
    val description: String,
    val imageResId: Int,  // Can be a URL or resource ID
    val tagLabel: String
)
