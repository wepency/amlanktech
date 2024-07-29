"use client"

import Image from "next/image"
import { image2 } from "@/assets"
import { Button } from "@mantine/core"
import Atropos from "atropos/react"

import "atropos/css"

export function HeroSection() {
  return (
    <main className="bg-gray-100">
      <div
        className={"container  flex min-h-[calc(100svh-60px)] items-center py-20 "}>
        <div className="flex flex-col-reverse  items-center gap-10 lg:flex-row">
          <div>
            <h1 className="text-3xl font-bold text-gray-900 max-lg:text-center lg:text-5xl">
              منصة أملاك التقنية
            </h1>

            <p className="mt-8 text-lg text-gray-600 max-lg:text-center lg:max-w-lg">
              منصة املاك تك هي منصة سعودية تهدف الى رقمنة التجمعات العقارية لتدعم
              التحول الرقمي في القطاع الرقمي اعتمادا على علوم البيانات والذكاء
              الاصطناعي لتعزيز المصداقية والشفافية لملاك التجمعات العقارية.
            </p>

            <Button size="lg" className="mt-8 px-20 max-lg:w-full">
              أبدا الان
            </Button>
          </div>
          <div>
            <Atropos
              rotateXMax={10}
              rotateYMax={10}
              shadow={false}
              activeOffset={40}>
              <Image src={image2} alt="image" />
            </Atropos>
          </div>
        </div>
      </div>
    </main>
  )
}
