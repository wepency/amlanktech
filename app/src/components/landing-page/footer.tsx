import React from "react"
import Image from "next/image"
import Link from "next/link"
import { logo } from "@/assets"

type Props = {}

const Footer = (props: Props) => {
  return (
    <footer className="bg-gray-100">
      <div className="relative mx-auto max-w-screen-xl px-4 py-16 sm:px-6 lg:px-8 lg:pt-24">
        <div className="lg:flex lg:items-end lg:justify-between">
          <div>
            <div className="flex justify-center text-Primary lg:justify-start">
              <Link href={"/"} className="flex items-center gap-3 font-bold">
                <Image src={logo} alt="logo" className="w-[50px]" />
                <p>منصة املاك</p>
              </Link>
            </div>

            <p className="mx-auto mt-6 max-w-md text-center leading-relaxed text-gray-500 lg:text-right">
              منصة املاك تك هي منصة سعودية تهدف الى رقمنة التجمعات العقارية لتدعم
              التحول الرقمي في القطاع الرقمي اعتمادا على علوم البيانات والذكاء
              الاصطناعي لتعزيز المصداقية والشفافية لملاك التجمعات العقارية.
            </p>
          </div>

          <ul className="mt-12 flex flex-wrap justify-center gap-6 md:gap-8 lg:mt-0 lg:justify-end lg:gap-12">
            <li>
              <a
                className="text-gray-700 transition hover:text-gray-700/75"
                href="#">
                {" "}
                الرئيسية{" "}
              </a>
            </li>

            <li>
              <a
                className="text-gray-700 transition hover:text-gray-700/75"
                href="#pricing">
                {" "}
                الباقات{" "}
              </a>
            </li>

            <li>
              <a
                className="text-gray-700 transition hover:text-gray-700/75"
                href="#contact-us">
                تواصل معنا
              </a>
            </li>
          </ul>
        </div>

        <p className="mt-12 text-center text-sm text-gray-500 lg:text-right">
          Copyright &copy; {new Date().getFullYear()} All rights reserved.
        </p>
      </div>
    </footer>
  )
}

export default Footer
