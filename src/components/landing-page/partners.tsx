import React from "react"
import Image from "next/image"
import { partner1, partner2 } from "@/assets"

type Props = {}

const partners = [
  partner1,
  partner2,
  partner1,
  partner2,
  partner1,
  partner2,
  partner1,
  partner2,
]
const Partners = (props: Props) => {
  return (
    <section className="bg-white py-20 text-[#3f3f3f]">
      <div className="container">
        <h3 className="mb-10 text-center text-lg font-medium lg:text-3xl">
          شراكات حكومية.. موثوقية
        </h3>
        <div className="flex flex-wrap justify-center  gap-10 lg:gap-16">
          {partners.map((partner, i) => (
            <Image
              loading="lazy"
              className="  w-full max-w-[100px] mix-blend-multiply grayscale duration-300 hover:filter-none lg:max-w-[200px]"
              key={i}
              src={partner}
              alt="brand"
            />
          ))}
        </div>
      </div>
    </section>
  )
}

export default Partners
