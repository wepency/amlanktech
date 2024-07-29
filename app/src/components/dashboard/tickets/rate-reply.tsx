"use client"

import React, { useState } from "react"
import AmlackApi from "@/api"
import { Rating } from "@mantine/core"

type Props = {
  id: string | number
  stars: null | number
}

const RateReply = ({ id, stars }: Props) => {
  const [rate, setRate] = useState(stars ?? 0)
  const handleChange = async (value: number) => {
    setRate(value)
    try {
      const response = await AmlackApi.post(
        `/support-tickets/reply/${id}/add-stars`,
        {
          stars: value,
        },
      )
    } catch (error) {
      console.log("🚀 ~ handleChange ~ error:", error)
    }
  }

  return (
    <div className="px-2">
      <label className="mb-1 block text-sm">تقييم الرد</label>
      <Rating value={rate} onChange={handleChange} />
    </div>
  )
}

export default RateReply
