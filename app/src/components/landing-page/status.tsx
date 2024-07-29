"use client"

import React from "react"
import CountUp from "react-countup"

type Props = {}

const Status = (props: Props) => {
  return (
    <section className="bg-gray-100 py-20 text-[#3f3f3f]">
      <div className="container">
        <h3 className="mb-10 text-center text-2xl font-medium">
          تقنيات عقارية ذات اعتمادية عالية
        </h3>
        <div className="flex flex-wrap gap-8  sm:justify-center  lg:justify-between lg:gap-10">
          <div>
            <p>
              <CountUp
                enableScrollSpy
                scrollSpyOnce
                end={137270}
                duration={4.75}
                start={0}
                delay={0.4}>
                {({ countUpRef }) => (
                  <span
                    className="text-[2.7rem] font-bold text-customBlack lg:text-[3.4rem]"
                    ref={countUpRef}></span>
                )}
              </CountUp>
              <span className="px-2 text-[1.5rem] font-bold text-[#a0a0a0] lg:text-[1.7rem]">
                عقار
              </span>
            </p>
            <p>يدار من خلال المنصة</p>
          </div>
          <div>
            <p>
              <CountUp
                enableScrollSpy
                scrollSpyOnce
                end={100000}
                duration={3.75}
                start={0}
                delay={0.4}>
                {({ countUpRef }) => (
                  <span
                    className="text-[2.7rem] font-bold text-customBlack lg:text-[3.4rem]"
                    ref={countUpRef}></span>
                )}
              </CountUp>

              <span className="px-2 text-[1.5rem] font-bold text-[#a0a0a0] lg:text-[1.7rem]">
                مستفيد
              </span>
            </p>
            <p>من خدماتنا</p>
          </div>
          <div>
            <p>
              <CountUp
                enableScrollSpy
                scrollSpyOnce
                end={5.4}
                decimal="."
                decimals={2}
                duration={2.75}
                start={0}
                delay={0.4}>
                {({ countUpRef }) => (
                  <span
                    className="text-[2.7rem] font-bold text-customBlack lg:text-[3.4rem]"
                    ref={countUpRef}></span>
                )}
              </CountUp>

              <span className="px-2 text-[1.5rem] font-bold text-[#a0a0a0] lg:text-[1.7rem]">
                مليار ريال
              </span>
            </p>
            <p>إجمالي قيم العقود التي تدار من خلال المنصة</p>
          </div>
        </div>
      </div>
    </section>
  )
}

export default Status
