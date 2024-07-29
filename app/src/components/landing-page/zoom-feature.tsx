import React from "react"
import Image from "next/image"
import { image1, image2 } from "@/assets"

import { WobbleCard } from "../ui/wobble-card"

type Props = {}

const ZoomFeature = (props: Props) => {
  return (
    <section>
      <div className="container relative py-10">
        <WobbleCard
          containerClassName="col-span-1 lg:col-span-2 h-full   h-full"
          className="">
          <div className="max-w-sm py-10">
            <h2 className="text-balance text-base  font-semibold tracking-[-0.015em] text-white max-sm:text-center md:text-xl lg:text-3xl">
              أجتمع مع اعضاء جمعيتك
            </h2>
            <p className="mt-4 text-base/6 text-neutral-200">
              .حدول اجتمعاتك وناقش اخر التطورات مع اعضاء حمعيتك مباشرة عبر منصتنا
            </p>
          </div>
          <Image
            src={image1.src}
            width={500}
            height={500}
            alt="linear demo image"
            className="-left-[40%] top-[30%] rounded-2xl object-contain md:absolute md:-left-[40%] lg:-left-[5%]"
          />
        </WobbleCard>
      </div>
    </section>
  )
}

export default ZoomFeature
